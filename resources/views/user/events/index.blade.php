@extends('layouts.master')

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

  :root {
    --bg: #ffffff;
    --surface: #FFFFFF;
    --surface-2: #F9F8F5;
    --border: rgba(0,0,0,0.07);
    --text-primary: #1A1917;
    --text-secondary: #6B6860;
    --text-muted: #A8A49E;
    --blue: #2E7DD1;
    --blue-bg: #E4EFF9;
    --blue-text: #1145A0;
    --green: #1D9E75;
    --green-bg: #E3F5EE;
    --green-text: #0A5E41;
    --amber: #C98A10;
    --amber-bg: #FEF3DC;
    --amber-text: #7A4F00;
    --red: #D94040;
    --red-bg: #FDECEC;
    --red-text: #8A1818;
    --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --shadow-md: 0 6px 24px rgba(0,0,0,0.09);
    --radius: 16px;
    --radius-sm: 10px;
  }

  .el-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 28px 32px 56px;
    background: var(--bg);
    min-height: 100vh;
    color: var(--text-primary);
  }

  /* ─── Header ─── */
  .el-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 22px;
  }
  .el-header h1 {
    font-size: 22px;
    font-weight: 700;
    letter-spacing: -.4px;
    margin: 0 0 4px;
  }
  .el-header p { font-size: 13px; color: var(--text-muted); margin: 0; }
  .el-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
    background: var(--surface);
    border: 1px solid var(--border);
    padding: 8px 16px;
    border-radius: 99px;
    text-decoration: none;
    transition: background .15s, color .15s;
  }
  .el-back:hover { background: #EEECEA; color: var(--text-primary); text-decoration: none; }

  /* ─── Alerts ─── */
  .el-alert {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    border-radius: var(--radius-sm);
    padding: 13px 16px;
    margin-bottom: 16px;
    font-size: 13.5px;
    font-weight: 500;
  }
  .el-alert-close {
    margin-left: auto;
    background: none;
    border: none;
    cursor: pointer;
    opacity: .5;
    padding: 0;
    line-height: 1;
    flex-shrink: 0;
  }
  .el-alert-close:hover { opacity: 1; }
  .el-alert.success { background: var(--green-bg); color: var(--green-text); border: 1px solid rgba(29,158,117,.2); }
  .el-alert.danger  { background: var(--red-bg);   color: var(--red-text);   border: 1px solid rgba(217,64,64,.2); }
  .el-alert ul { margin: 6px 0 0 16px; padding: 0; font-size: 13px; }

  /* ─── Search Bar ─── */
  .el-search-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 22px;
    box-shadow: var(--shadow);
    margin-bottom: 24px;
  }
  .el-search-row {
    display: grid;
    grid-template-columns: 1fr 220px auto;
    gap: 10px;
    align-items: center;
  }
  @media (max-width: 768px) { .el-search-row { grid-template-columns: 1fr; } }

  .el-input, .el-select {
    width: 100%;
    background: var(--surface-2);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 10px 14px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px;
    color: var(--text-primary);
    outline: none;
    transition: border-color .15s, box-shadow .15s, background .15s;
    appearance: none;
    -webkit-appearance: none;
  }
  .el-input::placeholder { color: var(--text-muted); }
  .el-input:focus, .el-select:focus {
    border-color: #1A1917;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(26,25,23,.07);
  }
  .el-select-wrap { position: relative; }
  .el-select-wrap::after {
    content: '';
    position: absolute;
    right: 13px; top: 50%;
    transform: translateY(-50%);
    width: 0; height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 5px solid var(--text-muted);
    pointer-events: none;
  }
  .el-search-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--text-primary);
    color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    padding: 10px 22px;
    border-radius: var(--radius-sm);
    border: none;
    cursor: pointer;
    white-space: nowrap;
    transition: opacity .15s;
  }
  .el-search-btn:hover { opacity: .82; }

  /* ─── Results Meta ─── */
  .el-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }
  .el-meta-count {
    font-size: 13px;
    color: var(--text-muted);
  }
  .el-meta-count strong { color: var(--text-primary); font-weight: 700; }

  /* ─── Event Grid ─── */
  .el-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin-bottom: 24px;
  }
  @media (max-width: 1024px) { .el-grid { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 640px)  { .el-grid { grid-template-columns: 1fr; } }

  /* ─── Event Card ─── */
  .ev-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: box-shadow .22s, transform .22s;
    text-decoration: none;
    color: inherit;
  }
  .ev-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-4px);
    text-decoration: none;
    color: inherit;
  }

  /* Banner */
  .ev-banner {
    position: relative;
    height: 190px;
    overflow: hidden;
    background: #E8E6E0;
    flex-shrink: 0;
  }
  .ev-banner img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .4s ease;
  }
  .ev-card:hover .ev-banner img { transform: scale(1.04); }
  .ev-banner-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #E8E6E0, #D9D6CE);
  }
  .ev-cat-pill {
    position: absolute;
    top: 12px; left: 12px;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 11px;
    border-radius: 99px;
    background: rgba(255,255,255,0.92);
    color: var(--text-primary);
    letter-spacing: .03em;
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255,255,255,.5);
  }

  /* Body */
  .ev-body {
    padding: 18px 20px 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
  }
  .ev-title {
    font-size: 15px;
    font-weight: 700;
    letter-spacing: -.2px;
    margin: 0 0 8px;
    line-height: 1.35;
    color: var(--text-primary);
  }
  .ev-desc {
    font-size: 12.5px;
    color: var(--text-muted);
    line-height: 1.6;
    margin: 0 0 14px;
    flex: 1;
  }

  /* Meta rows */
  .ev-metas { display: flex; flex-direction: column; gap: 7px; margin-bottom: 16px; }
  .ev-meta-row {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12.5px;
    color: var(--text-secondary);
  }
  .ev-meta-icon {
    width: 24px; height: 24px;
    border-radius: 6px;
    background: var(--surface-2);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }

  /* CTA */
  .ev-cta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 14px;
    border-top: 1px solid var(--border);
  }
  .ev-organizer { font-size: 12px; color: var(--text-muted); }
  .ev-organizer strong { color: var(--text-secondary); font-weight: 600; }
  .ev-detail-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--text-primary);
    color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12px;
    font-weight: 700;
    padding: 7px 16px;
    border-radius: 99px;
    text-decoration: none;
    transition: opacity .15s;
    white-space: nowrap;
  }
  .ev-detail-btn:hover { opacity: .82; color: #fff; text-decoration: none; }

  /* ─── Empty State ─── */
  .el-empty {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    text-align: center;
    padding: 64px 24px;
  }
  .el-empty-icon {
    width: 56px; height: 56px;
    background: #EEECEA;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
  }
  .el-empty h3 { font-size: 17px; font-weight: 700; margin: 0 0 7px; letter-spacing: -.2px; }
  .el-empty p { font-size: 13.5px; color: var(--text-muted); margin: 0; }

  /* ─── Pagination ─── */
  .el-pagination {
    display: flex;
    justify-content: center;
  }
  .el-pagination nav .flex { gap: 4px; justify-content: center; }
  .el-pagination nav span[aria-current="page"] > span,
  .el-pagination nav a {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    border-radius: 8px !important;
    border: 1px solid var(--border) !important;
    color: var(--text-secondary) !important;
    padding: 6px 12px !important;
    line-height: 1.4 !important;
    background: var(--surface) !important;
  }
  .el-pagination nav span[aria-current="page"] > span {
    background: var(--text-primary) !important;
    color: #fff !important;
    border-color: var(--text-primary) !important;
  }
  .el-pagination nav a:hover {
    background: #EEECEA !important;
    color: var(--text-primary) !important;
  }
</style>

<div class="el-wrap">

  {{-- Header --}}
  <div class="el-header">
    <div>
      <h1>Daftar Event</h1>
      <p>Temukan dan daftar event yang menarik untuk Anda</p>
    </div>
    <a href="{{ route('user.dashboard') }}" class="el-back">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
      Dashboard
    </a>
  </div>

  {{-- Alerts --}}
  @if ($errors->any())
    <div class="el-alert danger" id="errAlert">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <div>
        <strong>Terjadi Kesalahan!</strong>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      <button class="el-alert-close" onclick="this.closest('.el-alert').remove()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
  @endif

  @if (session('success'))
    <div class="el-alert success">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><polyline points="20 6 9 17 4 12"/></svg>
      {{ session('success') }}
      <button class="el-alert-close" onclick="this.closest('.el-alert').remove()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
  @endif

  @if (session('error'))
    <div class="el-alert danger">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ session('error') }}
      <button class="el-alert-close" onclick="this.closest('.el-alert').remove()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
  @endif

  {{-- Search --}}
  <div class="el-search-card">
    <form action="{{ route('user.events.index') }}" method="GET">
      <div class="el-search-row">
        <div style="position:relative">
          <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);pointer-events:none" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#A8A49E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" class="el-input" style="padding-left:36px" placeholder="Cari event, kategori, atau lokasi..."
            name="search" value="{{ request('search') }}">
        </div>
        <div class="el-select-wrap">
          <select class="el-select" name="category" id="category">
            <option value="">— Semua Kategori —</option>
            @php $categories = \App\Models\Category::all(); @endphp
            @foreach ($categories as $categories)
              <option value="{{ $categories->id }}"
                {{ request('categories') == $categories->id ? 'selected' : '' }}>
                {{ $categories->name }}
              </option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="el-search-btn">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          Cari
        </button>
      </div>
    </form>
  </div>

  {{-- Meta --}}
  @if ($events->count() > 0)
  <div class="el-meta">
    <p class="el-meta-count">Menampilkan <strong>{{ $events->count() }}</strong> dari <strong>{{ $events->total() }}</strong> event</p>
  </div>
  @endif

  {{-- Grid --}}
  @if ($events->count() > 0)
  <div class="el-grid">
    @foreach ($events as $event)
      <div class="ev-card">

        <div class="ev-banner">
          @if ($event->banner)
            <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->title }}">
          @else
            <div class="ev-banner-placeholder">
              <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#C5C1BA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
          @endif
          <span class="ev-cat-pill">{{ $event->category->name ?? 'Uncategorized' }}</span>
        </div>

        <div class="ev-body">
          <h3 class="ev-title">{{ Str::limit($event->title, 50) }}</h3>
          <p class="ev-desc">{{ Str::limit($event->description, 90) }}</p>

          <div class="ev-metas">
            <div class="ev-meta-row">
              <div class="ev-meta-icon">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#6B6860" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              </div>
              <span style="font-family:'DM Mono',monospace;font-size:12px">{{ $event->event_date->format('d M Y · H:i') }}</span>
            </div>
            <div class="ev-meta-row">
              <div class="ev-meta-icon">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#6B6860" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              </div>
              <span>{{ Str::limit($event->location, 38) }}</span>
            </div>
          </div>

          <div class="ev-cta">
            <div class="ev-organizer">
              by <strong>{{ $event->organizer->name }}</strong>
            </div>
            <a href="{{ route('user.events.show', $event->id) }}" class="ev-detail-btn">
              Lihat Detail
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
          </div>
        </div>

      </div>
    @endforeach
  </div>

  {{-- Pagination --}}
  <div class="el-pagination">
    {{ $events->links() }}
  </div>

  @else
  <div class="el-empty">
    <div class="el-empty-icon">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A8A49E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    </div>
    <h3>Belum Ada Event</h3>
    <p>Saat ini belum ada event yang tersedia. Silakan cek kembali nanti.</p>
  </div>
  @endif

</div>

@endsection

@section('ExtraCSS')
@endsection

@section('ExtraJS')
@endsection