<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\TicketType;

class EventController extends Controller
{
    // 📌 LIST EVENT
    public function index()
    {
        $events = Event::latest()->get();

        // ⬇️ SESUAIKAN KE FOLDER KAMU
        return view('admin.events.index', compact('events'));
    }

    // 📌 FORM CREATE
    public function create()
    {
        // 1. Ambil semua data kategori dari database
        $categories = Category::all();

        // 2. Kirim variabel $categories ke file blade menggunakan compact()
        return view('admin.events.createEvent', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'event_date' => 'required|date',
            'location' => 'required',
            'total_quota' => 'required|integer',
            'banner' => 'required|image|mimes:jpg,jpeg,png|max:2048',

            // 🔥 VALIDASI TICKET
            'ticket_name.*' => 'required',
            'ticket_price.*' => 'required|numeric',
            'ticket_quota.*' => 'required|integer',
        ]);

        // 🔥 HITUNG TOTAL QUOTA TICKET
        $totalTicketQuota = 0;

        for ($i = 0; $i < count($request->ticket_quota); $i++) {
            $totalTicketQuota += $request->ticket_quota[$i];
        }

        // ❗ VALIDASI HARUS SAMA
        if ($totalTicketQuota != $request->total_quota) {
            return back()->withErrors([
                'quota' => 'Total quota ticket harus sama dengan quota event!'
            ])->withInput();
        }

        // upload banner
        $banner = null;
        if ($request->hasFile('banner')) {
            $banner = $request->file('banner')->store('event_banner', 'public');
        }

        // 🔥 SIMPAN EVENT (UBAH DIKIT BIAR ADA VARIABEL)
        $event = Event::create([
            'organizer_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'banner' => $banner,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'total_quota' => $request->total_quota,
            'status' => 'Draft'
        ]);

        // 🔥 SIMPAN TICKET TYPES
        for ($i = 0; $i < count($request->ticket_name); $i++) {

            TicketType::create([
                'event_id' => $event->id,
                'name' => $request->ticket_name[$i],
                'price' => $request->ticket_price[$i],
                'quota' => $request->ticket_quota[$i],
                'remaining_quota' => $request->ticket_quota[$i]
            ]);
        }

        return redirect()->route('events.index')
            ->with('success', 'Event + Ticket berhasil dibuat');
    }

    // 📌 FORM EDIT
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all(); // Ambil semua kategori dari database (untuk memunculkan list di dropdown)
        return view('admin.events.editEvent', compact('event', 'categories'));
    }

    // 📌 UPDATE
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'event_date' => 'required|date',
            'location' => 'required',
            'total_quota' => 'required|integer',
            'status' => 'required',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'required',

            // 🔥 VALIDASI TICKET
            'ticket_name.*' => 'required',
            'ticket_price.*' => 'required|numeric',
            'ticket_quota.*' => 'required|integer',


        ]);
        // 🔥 HITUNG TOTAL QUOTA TICKET
        // $totalTicketQuota = 0;

        // for ($i = 0; $i < count($request->ticket_quota); $i++) {
        //     $totalTicketQuota += $request->ticket_quota[$i];
        // }

        // ❗ VALIDASI HARUS SAMA
        // if ($totalTicketQuota != $request->total_quota) {
        //     return back()->withErrors([
        //         'quota' => 'Total quota ticket harus sama dengan quota event!'
        //     ])->withInput();
        // }


        // 📌 HANDLE BANNER UPDATE
        if ($request->hasFile('banner')) {

            // hapus banner lama
            if ($event->banner && Storage::disk('public')->exists($event->banner)) {
                Storage::disk('public')->delete($event->banner);
            }

            $banner = $request->file('banner')->store('event_banner', 'public');

            $event->banner = $banner;
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'total_quota' => $request->total_quota,
            'status' => $request->status,
            'category_id' => $request->category_id


        ]);



        return redirect()->route('events.index')
            ->with('success', 'Event berhasil diupdate');
    }

    // 📌 DELETE
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        // hapus banner
        if ($event->banner && Storage::disk('public')->exists($event->banner)) {
            Storage::disk('public')->delete($event->banner);
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil dihapus'
        ]);
    }
}