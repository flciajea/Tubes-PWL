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
     * Tampilkan halaman checkout/payment
     */
    public function show(Request $request, $orderId)
    {
        $user = $request->user();
        $order = Order::with('event', 'orderItems', 'payment')
            ->findOrFail($orderId);

        // Validasi: order milik user yang login
        if ($order->user_id != $user->id) {
            return redirect()->back()->with('error', 'Tidak bisa akses order ini!');
        }

        // Jika sudah ada payment dengan status success, redirect ke berhasil
        if ($order->payment && $order->payment->payment_status === 'success') {
            return redirect()->route('user.payment.success', $order->id)
                ->with('info', 'Pembayaran sudah selesai!');
        }

        return view('user.payment.checkout', compact('order'));
    }

    /**
     * Proses pembayaran
     */
    public function process(Request $request, $orderId)
    {
        $user = $request->user();
        $order = Order::findOrFail($orderId);

        // Validasi: order milik user yang login
        if ($order->user_id != $user->id) {
            return redirect()->back()->with('error', 'Tidak bisa akses order ini!');
        }

        // VALIDASI INPUT
        $validated = $request->validate([
            'payment_channel' => 'required|in:Bank Transfer,Credit Card,E-Wallet,Cash',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update order payment_method
        $order->update([
            'payment_method' => $validated['payment_channel'],
            'status' => 'pending',
        ]);

        // Jika sudah ada payment, gunakan yang ada
        $payment = $order->payment;

        if (!$payment) {
            // BUAT PAYMENT BARU
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_channel' => $validated['payment_channel'],
                'payment_status' => 'pending',
            ]);
        } else {
            // UPDATE PAYMENT YANG ADA
            $payment->update([
                'payment_channel' => $validated['payment_channel'],
                'payment_status' => 'pending',
            ]);
        }

        // HANDLE UPLOAD BUKTI PEMBAYARAN
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = 'payments/' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public', $filename);
            
            // Store in order's payment_reference (or create table baru untuk proof jika perlu)
        }

        // SIMULASI VERIFIKASI PEMBAYARAN
        // Dalam production, connect ke payment gateway (Midtrans, Stripe, dll)
        return redirect()->route('user.payment.verify', $payment->id)
            ->with('success', 'Payment berhasil diproses!');
    }

    /**
     * Verifikasi pembayaran
     */
    public function verify(Request $request, $paymentId)
    {
        $user = $request->user();
        $payment = Payment::with('order')
            ->findOrFail($paymentId);

        // Validasi: payment milik user yang login
        if ($payment->order->user_id != $user->id) {
            return redirect()->back()->with('error', 'Tidak bisa akses pembayaran ini!');
        }

        // SIMULASI: Ubah status payment menjadi success
        // Dalam production, ini dilakukan melalui webhook dari payment gateway
        $payment->update([
            'payment_status' => 'success',
            'paid_at' => now(),
        ]);

        // UPDATE ORDER STATUS
        $order = $payment->order;
        $order->update([
            'status' => 'paid',
        ]);

        return redirect()->route('user.payment.success', $order->id)
            ->with('success', 'Pembayaran berhasil! Event sudah terdaftar.');
    }

    /**
     * Halaman sukses pembayaran
     */
    public function success(Request $request, $orderId)
    {
        $user = $request->user();
        $order = Order::with('event', 'orderItems', 'payment')
            ->findOrFail($orderId);

        // Validasi: order milik user yang login
        if ($order->user_id != $user->id) {
            return redirect()->back()->with('error', 'Tidak bisa akses order ini!');
        }

        // Check status pembayaran
        if ($order->status != 'paid' || !$order->payment || $order->payment->payment_status != 'success') {
            return redirect()->route('user.payment.show', $order->id)
                ->with('error', 'Pembayaran belum dikonfirmasi!');
        }

        return view('user.payment.success', compact('order'));
    }

    /**
     * List pembayaran user
     */
    public function history(Request $request)
    {
        $user = $request->user();

        $payments = Payment::whereHas('order', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with('order.event', 'order.orderItems')
        ->latest()
        ->paginate(10);

        return view('user.payment.history', compact('payments'));
    }

    /**
     * Download bukti pembayaran / e-ticket
     */
    public function downloadTicket(Request $request, $orderId)
    {
        $user = $request->user();
        $order = Order::with('event', 'orderItems')->findOrFail($orderId);

        // Validasi: order milik user yang login
        if ($order->user_id != $user->id) {
            return redirect()->back()->with('error', 'Tidak bisa mengakses ticket ini!');
        }

        // Check status
        if ($order->status != 'paid') {
            return redirect()->back()->with('error', 'Ticket belum tersedia!');
        }

        // Generate ticket info dari order items
        $itemInfo = $order->orderItems->map(function($item) {
            return "{$item->ticketType->name} x{$item->quantity}";
        })->join(', ');

        // Return JSON dengan info
        return response()->json([
            'registration_code' => $order->payment_reference,
            'event_name' => $order->event->title,
            'items' => $itemInfo,
            'event_date' => $order->event->event_date->format('d M Y H:i'),
            'location' => $order->event->location,
            'total_amount' => $order->total_amount,
        ]);
    }
}
