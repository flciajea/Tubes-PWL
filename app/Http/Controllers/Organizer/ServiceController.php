<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\WaitingList;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TicketType;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function processWaitingList($ticketTypeId)
    {
        $waiting = WaitingList::with('ticketType')
            ->where('ticket_type_id', $ticketTypeId)
            ->where('status', 'waiting')
            ->orderBy('created_at')
            ->first();

        if (!$waiting || !$waiting->ticketType)
            return;

        $order = Order::create([
            'user_id' => $waiting->user_id,
            'event_id' => $waiting->ticketType->event_id,
            'total_amount' => $waiting->ticketType->price,
            'status' => 'pending',
            'payment_method' => null,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'ticket_type_id' => $ticketTypeId,
            'quantity' => 1
        ]);

        $waiting->update([
            'status' => 'processed'
        ]);
    }

    public function handleTicketPurchase(TicketType $ticket)
    {
        if ($ticket->stock <= 0) {
            WaitingList::create([
                'user_id' => Auth::id(),
                'ticket_type_id' => $ticket->id,
                'status' => 'waiting'
            ]);

            return back()->with('info', 'Masuk waiting list');
        }

        // lanjut proses beli normal
    }

    public function waitingList()
    {
        $orders = Order::with([
            'user',
            'orderItems.ticketType.event',
            'payment' // 🔥 INI PENTING
        ])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('organizer.waiting-list', compact('orders'));
    }

    public function orders()
    {
        $orders = Order::with([
            'user',
            'event',
            'payment'
        ])
            ->latest()
            ->get();

        return view('organizer.orders', compact('orders'));
    }

    public function approve($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);

        $order->update([
            // Ganti 'confirmed' menjadi 'paid' (karena di enum adanya 'paid')
            'status' => 'paid'
        ]);

        $ticketTypeId = $order->orderItems->first()->ticket_type_id ?? null;

        if ($ticketTypeId) {
            \App\Models\WaitingList::where('ticket_type_id', $ticketTypeId)
                ->where('status', 'waiting')
                ->update(['status' => 'notified']);
        }

        return redirect()->back()->with('success', 'Order approved');
    }

    public function reject($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            // Ganti 'rejected' menjadi 'failed' atau 'cancelled' 
            // (pilih salah satu yang ada di enum database Anda)
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Order rejected');
    }

    public function cancelOrder($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);

        $order->update([
            // Ganti 'rejected' menjadi 'cancelled'
            'status' => 'cancelled'
        ]);

        foreach ($order->orderItems as $item) {
            $this->processWaitingList($item->ticket_type_id);
        }

        return back()->with('success', 'Order dibatalkan & waiting list diproses');
    }

    public function approveOrder($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => 'success'
        ]);

        return back()->with('success', 'Order berhasil di-approve');
    }

    public function orderHistory()
    {
        $orders = Order::with([
            'user',
            'orderItems.ticketType.event',
            'payment'
        ])
            ->whereIn('status', ['paid', 'cancelled', 'failed']) // Menampilkan yang sudah diproses
            ->latest()
            ->get();

        return view('organizer.order-history', compact('orders'));
    }
}