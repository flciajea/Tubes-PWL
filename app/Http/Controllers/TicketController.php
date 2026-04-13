<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CREATE TIKET (STORE)
    |--------------------------------------------------------------------------
    */
    public function store(Request $r)
    {
        $t = Ticket::create([
            'user_id' => Auth::id(), // user login
            'order_item_id' => $r->order_item_id
        ]);

        return redirect('/ticket/' . $t->id);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW TIKET + QR
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $t = Ticket::find($id);

        if (!$t) {
            return "Tiket tidak ditemukan";
        }

        return view('ticket', ['t' => $t]);
    }

    /*
    |--------------------------------------------------------------------------
    | LIST SEMUA TIKET (ADMIN)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $t = Ticket::with('user')->get();
        return view('tickets.index', ['t' => $t]);
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK-IN DARI QR
    |--------------------------------------------------------------------------
    */
    public function checkin($kode)
    {
        $t = Ticket::where('ticket_code', $kode)->first();

        if (!$t) {
            return "❌ Tiket tidak ditemukan";
        }

        if ($t->isUsed()) {
            return "⚠️ Tiket sudah digunakan";
        }

        $t->checkin();

        return "✅ Check-in berhasil";
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS TIKET
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $t = Ticket::find($id);

        if ($t) {
            $t->delete();
        }

        return redirect('/tickets');
    }
}