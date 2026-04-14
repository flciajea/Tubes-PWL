<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Exports\DashboardExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\WaitingList;

class DashboardController extends Controller
{
    public function index()
    {
        // 🔥 eager load biar tidak N+1
        $orders = Order::with('orderItems')
            ->where('status', 'paid')
            ->get();

        $totalRevenue = $orders->sum('total_amount');
        $totalTransactions = $orders->count();

        // 🔥 lebih clean pakai collection
        $totalTickets = $orders->sum(function ($o) {
            return $o->orderItems->sum('quantity');
        });

        // 📊 chart
        $chartData = Order::where('status', 'paid')
            ->selectRaw('DATE(created_at) as tanggal, SUM(total_amount) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // 🔥 EVENT ANALYTICS (FIXED)
        $eventAnalytics = Order::with('event', 'orderItems')
            ->where('status', 'paid')
            ->whereNotNull('event_id') // 🔥 hindari null
            ->get()
            ->groupBy('event_id')
            ->map(function ($orders) {

                $firstOrder = $orders->first();

                $revenue = $orders->sum('total_amount');
                $transactions = $orders->count();

                $tickets = $orders->sum(function ($o) {
                    return $o->orderItems->sum('quantity');
                });

                return [
                    'event_name' => $firstOrder->event
                        ? $firstOrder->event->title
                        : 'Event Tidak Diketahui',
                    'revenue' => $revenue,
                    'transactions' => $transactions,
                    'tickets' => $tickets,
                ];
            })
            ->sortByDesc('revenue')
            ->values();

        return view('organizer.dashboard', compact(
            'totalRevenue',
            'totalTransactions',
            'totalTickets',
            'chartData',
            'eventAnalytics'
        ));
    }

    public function exportExcel()
    {
        return Excel::download(new DashboardExport, 'report.xlsx');
    }

    public function waitingList()
    {
        $waitingLists = WaitingList::with('ticketType.event')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.waiting-list', compact('waitingLists'));
    }
    
}