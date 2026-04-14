<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

class DashboardExport implements FromCollection
{
    public function collection()
    {
        return Order::with('event')
            ->where('status', 'paid')
            ->get()
            ->map(function ($o) {
                return [
                    'Event' => optional($o->event)->name,
                    'Total Amount' => $o->total_amount,
                    'Status' => $o->status,
                    'Tanggal' => $o->created_at->format('Y-m-d'),
                ];
            });
    }
}