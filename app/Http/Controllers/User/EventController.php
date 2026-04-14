<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Ticket;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{
    /**
     * Tampilkan daftar events untuk user
     */
    public function index(Request $request)
    {
        $query = Event::where('status', 'Published')
            ->with('category', 'organizer');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $events = $query->paginate(12);

        return view('user.events.index', compact('events'));
    }

    /**
     * Tampilkan detail event dan ticket types
     */
    public function show($id)
    {
        $event = Event::with('category', 'organizer', 'ticketTypes')
            ->findOrFail($id);

        // Hitung total orders (pending + paid) untuk quota
        $totalOrders = Order::where('event_id', $id)
            ->whereIn('status', ['pending', 'paid'])
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->sum('order_items.quantity');

        $availableQuota = $event->total_quota - $totalOrders;

        return view('user.events.show', compact('event', 'availableQuota'));
    }

    /**
     * Tampilkan form registrasi event
     */
    public function register($eventId)
    {
        $event = Event::with('ticketTypes')
            ->findOrFail($eventId);

        // Check jika event sudah penuh (pending + paid)
        $totalOrders = Order::where('event_id', $eventId)
            ->whereIn('status', ['pending', 'paid'])
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->sum('order_items.quantity');

        $availableQuota = $event->total_quota - $totalOrders;

        if ($availableQuota <= 0) {
            return redirect()->back()->with('error', 'Event ini sudah penuh!');
        }

        return view('user.events.register', compact('event', 'availableQuota'));
    }

    /**
     * Proses registrasi event
     */
    public function storeRegistration(Request $request, $eventId)
    {
        $user = $request->user();

        // VALIDASI
        $validated = $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Validasi Ticket Type
        $ticketType = TicketType::findOrFail($validated['ticket_type_id']);

        if ($ticketType->event_id != $eventId) {
            return redirect()->back()->with('error', 'Ticket type tidak valid untuk event ini!');
        }

        // Check Available Quota (pending + paid)
        $event = Event::findOrFail($eventId);
        $totalOrders = Order::where('event_id', $eventId)
            ->whereIn('status', ['pending', 'paid'])
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->sum('order_items.quantity');

        $availableQuota = $event->total_quota - $totalOrders;

        if ($validated['quantity'] > $availableQuota) {
            return redirect()->back()->with('error', 'Quota tidak mencukupi! Tersisa: ' . $availableQuota);
        }

        // Cek apakah user sudah order untuk ticket type yang sama event ini
        $existingOrder = Order::where('user_id', $user->id)
            ->where('event_id', $eventId)
            ->whereHas('orderItems', function ($q) use ($validated) {
                $q->where('ticket_type_id', $validated['ticket_type_id']);
            })
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existingOrder) {
            return redirect()->back()->with('error', 'Anda sudah mendaftar untuk ticket type ini!');
        }

        // HITUNG TOTAL HARGA & SUBTOTAL
        $subtotal = $ticketType->price * $validated['quantity'];

        // BUAT ORDER
        $order = Order::create([
            'user_id' => $user->id,
            'event_id' => $eventId,
            'total_amount' => $subtotal,
            'status' => 'pending',
            'payment_method' => null,
            'payment_reference' => 'REG-' . Str::upper(Str::random(12)),
        ]);

        // BUAT ORDER ITEM
        OrderItem::create([
            'order_id' => $order->id,
            'ticket_type_id' => $validated['ticket_type_id'],
            'quantity' => $validated['quantity'],
            'price' => $ticketType->price,
            'subtotal' => $subtotal,
        ]);

        return redirect()->route('user.payment.show', $order->id)
            ->with('success', 'Registrasi berhasil! Lanjutkan ke pembayaran.');
    }

    /**
     * Tampilkan dashboard dengan orders user
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();

        // Ambil ALL orders untuk dashboard (bukan hanya paid)
        $registrations = Order::where('user_id', $user->id)
            ->with('event', 'orderItems', 'payment')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Upcoming events yang statusnya paid
        $upcomingEvents = $registrations
            ->where('status', 'paid')
            ->filter(function ($order) {
                return $order->event->event_date > now();
            });

        return view('user.dashboard', compact('registrations', 'upcomingEvents'));
    }

    /**
     * Tampilkan riwayat orders
     */
    public function history(Request $request)
    {
        $user = $request->user();

        $registrations = Order::where('user_id', $user->id)
            ->with('event', 'orderItems', 'payment')
            ->latest()
            ->paginate(10);

        return view('user.events.history', compact('registrations'));
    }

    /**
     * Batalkan order
     */
    public function cancelOrder(Request $request, $orderId)
    {
        $user = $request->user();
        $order = Order::findOrFail($orderId);

        // Validasi: order milik user yang login
        if ($order->user_id != $user->id) {
            return redirect()->back()->with('error', 'Tidak bisa membatalkan order ini!');
        }

        // Hanya pending yang bisa dibatalkan
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya order pending yang bisa dibatalkan!');
        }

        // Update status menjadi cancelled
        $order->update(['status' => 'cancelled']);

        // Hapus payment jika ada
        if ($order->payment) {
            $order->payment->delete();
        }

        return redirect()->route('user.events.history')
            ->with('success', 'Order berhasil dibatalkan!');
    }
    public function success($orderId)
    {
        $order = Order::with('orderItems', 'user')->findOrFail($orderId);

        // update status jadi paid
        $order->status = 'paid';
        $order->save();

        $tickets = [];

        // 🔥 GENERATE TICKET + QR FILE
        foreach ($order->orderItems as $item) {

            for ($i = 0; $i < $item->quantity; $i++) {

                $ticket = Ticket::create([
                    'user_id' => $order->user_id,
                    'order_item_id' => $item->id
                ]);

                // buat file QR di storage
                $fileName = 'qrcodes/' . $ticket->ticket_code . '.png';

                QrCode::format('png')
                    ->size(300)
                    ->generate($ticket->qr_code, storage_path('app/public/' . $fileName));

                // simpan path ke database (opsional, kalau mau)
                $ticket->qr_code = $fileName;
                $ticket->save();

                $tickets[] = $ticket;
            }
        }

        // 🔥 KIRIM EMAIL KE USER
        Mail::send('emails.ticket', ['tickets' => $tickets, 'order' => $order], function ($m) use ($order, $tickets) {

            $m->to($order->user->email)
                ->subject('Tiket Event Anda');

            // attach semua QR
            foreach ($tickets as $t) {
                $path = storage_path('app/public/' . $t->qr_code);
                if (file_exists($path)) {
                    $m->attach($path);
                }
            }
        });

        return redirect()->route('user.dashboard')
            ->with('success', 'Pembayaran berhasil, tiket sudah dikirim ke email!');
    }

    public function store(Request $request)
    {
        Order::create([
            'user_id' => auth()->id(),
            'event_id' => $request->event_id,
            'total_amount' => $request->total,
            'status' => 'pending', // WAJIB
            'payment_method' => $request->payment_method,
            'payment_reference' => null,
        ]);

        return redirect()->route('user.orders')
            ->with('success', 'Pesanan berhasil dibuat, menunggu konfirmasi organizer.');
    }
}
