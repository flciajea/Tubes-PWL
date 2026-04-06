<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketType;
use App\Models\Event;

class TicketTypeController extends Controller
{
    // Tampilkan semua ticket type per event
    public function index($event_id)
    {
        $event = Event::findOrFail($event_id);
        $tickets = TicketType::where('event_id', $event_id)->get();

        return view('ticket_types.index', compact('event', 'tickets'));
    }

    // Form tambah tiket
    public function create($event_id)
    {
        $event = Event::findOrFail($event_id);
        return view('ticket_types.create', compact('event'));
    }

    // Simpan tiket baru
    public function store(Request $r, $event_id)
    {
        $r->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quota' => 'required|integer'
        ]);

        TicketType::create([
            'event_id' => $event_id,
            'name' => $r->name,
            'price' => $r->price,
            'quota' => $r->quota,
            'remaining_quota' => $r->quota
        ]);

        return redirect()->route('ticket.index', $event_id)
                         ->with('success', 'Tiket berhasil ditambahkan');
    }

    // Form edit
    public function edit($id)
    {
        $ticket = TicketType::findOrFail($id);
        return view('ticket_types.edit', compact('ticket'));
    }

    // Update tiket
    public function update(Request $r, $id)
    {
        $ticket = TicketType::findOrFail($id);

        $r->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quota' => 'required|integer'
        ]);

        $ticket->update([
            'name' => $r->name,
            'price' => $r->price,
            'quota' => $r->quota,
            'remaining_quota' => $r->quota // reset
        ]);

        return redirect()->route('ticket.index', $ticket->event_id)
                         ->with('success', 'Tiket berhasil diupdate');
    }

    // Hapus tiket
    public function destroy($id)
    {
        $ticket = TicketType::findOrFail($id);
        $event_id = $ticket->event_id;

        $ticket->delete();

        return redirect()->route('ticket.index', $event_id)
                         ->with('success', 'Tiket berhasil dihapus');
    }
}