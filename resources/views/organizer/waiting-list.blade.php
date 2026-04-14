@extends('layouts.master')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

        :root {
            --bg: #ffffff;
            --surface: #FFFFFF;
            --surface-2: #F9F8F5;
            --border: rgba(0, 0, 0, 0.07);
            --text-primary: #1A1917;
            --text-secondary: #6B6860;
            --text-muted: #A8A49E;
            --amber: #C98A10;
            --amber-bg: #FEF3DC;
            --amber-text: #7A4F00;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.07), 0 1px 4px rgba(0, 0, 0, 0.05);
            --radius: 16px;
        }

        .wl-wrap {
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 28px 32px 48px;
            background: var(--bg);
            min-height: 100vh;
            color: var(--text-primary);
        }

        .wl-header {
            margin-bottom: 28px;
        }

        .wl-header h1 {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .wl-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
        }

        .wl-group {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 18px;
            overflow: hidden;
        }

        .wl-group-header {
            display: flex;
            justify-content: space-between;
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            background: var(--surface-2);
        }

        .wl-group-left {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .wl-group-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: var(--amber-bg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wl-event-name {
            font-size: 14px;
            font-weight: 700;
            margin: 0;
        }

        .wl-ticket-name {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0;
        }

        .wl-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--amber-bg);
            color: var(--amber-text);
            font-size: 12px;
            font-weight: 600;
            padding: 5px 13px;
            border-radius: 99px;
        }

        .wl-table {
            width: 100%;
            border-collapse: collapse;
        }

        .wl-table th {
            text-align: left;
            font-size: 11px;
            color: var(--text-muted);
            padding: 12px 24px;
            border-bottom: 1px solid var(--border);
        }

        .wl-table td {
            padding: 13px 24px;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
        }

        .td-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #E0D6FF;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: 700;
        }
    </style>

    <div class="wl-wrap">

        <div class="wl-header">
            <h1>Waiting List</h1>
            <p>Daftar antrian tiket per event</p>
        </div>

        @forelse($orders as $order)
            @php
                $ticketType = $order->ticketType;
                $event = $ticketType?->event;
            @endphp

            <div class="wl-group">

                <div class="wl-group-header">
                    <div class="wl-group-left">

                        <div class="wl-group-icon">
                            🎫
                        </div>

                        <div>
                            <p class="wl-event-name">
                                {{ $event->name ?? 'Event' }}
                            </p>
                            <p class="wl-ticket-name">
                                {{ $order->ticketType->name ?? 'Tiket' }}
                            </p>
                        </div>

                    </div>

                    <span class="wl-count-badge">
                        {{ $orders->count() }} antrian
                    </span>
                </div>

                <table class="wl-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Waktu</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <span class="td-avatar">
                                    {{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}
                                </span>
                                {{ $order->user->name ?? '-' }}
                            </td>

                            <td>{{ $order->user->email ?? '-' }}</td>

                            <td>{{ $order->created_at?->format('d M Y H:i') }}</td>

                            <td>
                                @if (!empty($order->payment?->payment_proof))
                                    <a href="{{ asset('storage/' . $order->payment->payment_proof) }}" target="_blank"
                                        class="btn btn-info btn-sm" style="font-size: 11px; padding: 4px 8px;">
                                        Lihat Bukti
                                    </a>
                                @else
                                    <span class="text-muted" style="font-size: 11px;">Belum Upload</span>
                                @endif
                            </td>

                            <td style="display: flex; gap: 5px;">
                                <form action="{{ route('organizer.orders.reject', $order->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">Reject</button>
                                </form>

                                <form action="{{ route('organizer.orders.approve', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

        @empty
            <div class="wl-group">
                <div class="wl-group-header">
                    Tidak ada waiting list
                </div>
            </div>
        @endforelse

    </div>
@endsection
