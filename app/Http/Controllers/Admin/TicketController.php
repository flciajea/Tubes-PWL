<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN SCAN QR
    |--------------------------------------------------------------------------
    */
    public function scan()
    {
         return view('organizer.tickets.scan');
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI QR (DARI HASIL SCAN)
    |--------------------------------------------------------------------------
    */
    public function validateQr(Request $request)
    {
        $request->validate([
            'qr_code' => 'required'
        ]);

        // ambil kode dari QR (biasanya link /checkin/TKT12345)
        $qr = $request->qr_code;

        // ambil kode tiket dari URL
        $kode = basename($qr);

        $t = Ticket::where('ticket_code', $kode)->first();

        if (!$t) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tiket tidak ditemukan'
            ]);
        }

        if ($t->status == 'used') {
            return response()->json([
                'status' => 'warning',
                'message' => 'Tiket sudah digunakan',
                'ticket' => $t
            ]);
        }

        // update check-in
        $t->status = 'used';
        $t->checkin_time = now();
        $t->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Check-in berhasil',
            'ticket' => $t
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI MANUAL (OPTIONAL)
    |--------------------------------------------------------------------------
    */
    public function manual($kode)
    {
        $t = Ticket::where('ticket_code', $kode)->first();

        if (!$t) {
            return "❌ Tiket tidak ditemukan";
        }

        if ($t->status == 'used') {
            return "⚠️ Tiket sudah digunakan";
        }

        $t->status = 'used';
        $t->checkin_time = now();
        $t->save();

        return "✅ Check-in berhasil";
    }
}