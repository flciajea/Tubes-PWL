<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

public function index()
{
    // ambil hanya yang sudah bayar
    $orders = Order::where('status', 'paid')->get();

    // total revenue
    $totalRevenue = $orders->sum('total_amount');

    // total transaksi
    $totalTransactions = $orders->count();

    // total tiket
    $totalTickets = 0;
    foreach ($orders as $o) {
        foreach ($o->orderItems as $item) {
            $totalTickets += $item->quantity;
        }
    }

    $chartData = Order::where('status', 'paid')
    ->selectRaw('DATE(created_at) as tanggal, SUM(total_amount) as total')
    ->groupBy('tanggal')
    ->orderBy('tanggal')
    ->get();

    return view('organizer.dashboard', compact(
    'totalRevenue',
    'totalTransactions',
    'totalTickets',
    'chartData' // 🔥 ini tambahan
));
}
}
