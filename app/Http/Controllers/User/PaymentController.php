<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * SHOW CHECKOUT PAGE
     */
    public function show(Request $request, $orderId)
    {
        $order = Order::with('event', 'orderItems', 'payment')
            ->findOrFail($orderId);

        // auth check
        if ($order->user_id != $request->user()->id) {
            return back()->with('error', 'Tidak bisa akses order ini');
        }

        // kalau sudah sukses payment → langsung success page
        if ($order->payment && $order->payment->payment_status === 'success') {
            return redirect()->route('user.payment.success', $order->id);
        }

        return view('user.payment.checkout', compact('order'));
    }

    /**
     * PROCESS PAYMENT
     */
    public function process(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->user_id != $request->user()->id) {
            return back()->with('error', 'Tidak bisa akses order ini');
        }

        $validated = $request->validate([
            'payment_channel' => 'required|in:Bank Transfer,Credit Card,E-Wallet,Cash',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        // update order
        $order->update([
            'payment_method' => $validated['payment_channel'],
            'status' => 'pending',
        ]);

        // create or update payment
        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_channel' => $validated['payment_channel'],
                'payment_status' => 'pending',
                'amount' => $order->total_amount,
            ]
        );

        // 2. LOGIKA UPLOAD (Perbaiki bagian ini)
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');

            // Buat nama file yang unik
            $fileNameOnly = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            /* Simpan ke disk 'public'. 
               Secara otomatis akan masuk ke folder: storage/app/public/payments/
            */
            $file->storeAs('payments', $fileNameOnly, 'public');

            // SIMPAN PATH KE DATABASE (agar bisa dipanggil dengan asset('storage/' . $path))
            $payment->update([
                'payment_proof' => 'payments/' . $fileNameOnly
            ]);
        }

        return redirect()->route('user.payment.verify', $payment->id);
    }

    /**
     * VERIFY PAYMENT (SIMULASI / WEBHOOK)
     */
    public function verify(Request $request, $paymentId)
    {
        $payment = Payment::with('order')->findOrFail($paymentId);

        if ($payment->order->user_id != $request->user()->id) {
            return back()->with('error', 'Tidak bisa akses pembayaran ini');
        }

        // update payment success
        $payment->update([
            'payment_status' => 'success',
            'paid_at' => now(),
        ]);

        // ❗ PENTING: TIDAK langsung confirmed
        // harus tunggu organizer approval
        $payment->order->update([
            'status' => 'pending',
        ]);

        return redirect()->route('user.payment.success', $payment->order->id);
    }

    /**
     * SUCCESS PAGE
     */
    public function success(Request $request, $orderId)
    {
        $order = Order::with('event', 'orderItems', 'payment')
            ->findOrFail($orderId);

        if ($order->user_id != $request->user()->id) {
            return back()->with('error', 'Tidak bisa akses order ini');
        }

        // validasi payment
        if (!$order->payment || $order->payment->payment_status !== 'success') {
            return redirect()->route('user.payment.show', $order->id);
        }

        return view('user.payment.success', compact('order'));
    }

    /**
     * HISTORY
     */

    public function history(Request $request)
    {
        $user = $request->user();

        $query = Payment::whereHas('order', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });

        $totalAmount = (clone $query)
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->sum('orders.total_amount');

        $successAmount = (clone $query)
            ->where('payment_status', 'success')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->sum('orders.total_amount');

        $pendingAmount = (clone $query)
            ->where('payment_status', 'pending')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->sum('orders.total_amount');

        $failedAmount = (clone $query)
            ->where('payment_status', 'failed')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->sum('orders.total_amount');

        $payments = $query->with('order.event', 'order.orderItems.ticketType')
            ->latest()
            ->paginate(10);

        return view('user.payment.history', compact(
            'payments',
            'totalAmount',
            'successAmount',
            'pendingAmount',
            'failedAmount'
        ));
    }

    /**
     * DOWNLOAD TICKET
     */
    public function downloadTicket(Request $request, $orderId)
    {
        $order = Order::with('event', 'orderItems')
            ->findOrFail($orderId);

        if ($order->user_id != $request->user()->id) {
            return back()->with('error', 'Tidak bisa akses ticket ini');
        }

        // ❗ hanya boleh kalau sudah CONFIRMED oleh organizer
        if ($order->status !== 'confirmed') {
            return back()->with('error', 'Ticket belum disetujui organizer');
        }

        $items = $order->orderItems->map(function ($item) {
            return $item->ticketType->name . ' x' . $item->quantity;
        })->join(', ');

        return response()->json([
            'event_name' => $order->event->title,
            'items' => $items,
            'total_amount' => $order->total_amount,
            'status' => $order->status,
        ]);
    }
}