@extends('layouts.master')

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

  :root {
    --bg: #ffffff;
    --surface: #FFFFFF;
    --surface-2: #F9F8F5;
    --border: rgba(0,0,0,0.08);
    --border-focus: #1A1917;
    --text-primary: #1A1917;
    --text-secondary: #6B6860;
    --text-muted: #A8A49E;
    --green: #1D9E75;
    --green-bg: #E3F5EE;
    --green-text: #0A5E41;
    --blue: #2E7DD1;
    --blue-bg: #E4EFF9;
    --blue-text: #1145A0;
    --amber: #C98A10;
    --amber-bg: #FEF3DC;
    --amber-text: #7A4F00;
    --red: #D94040;
    --red-bg: #FDECEC;
    --red-text: #8A1818;
    --radius: 14px;
    --radius-sm: 10px;
    --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
  }

  .ee-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 28px 32px 56px;
    background: var(--bg);
    min-height: 100vh;
    color: var(--text-primary);
  }

  /* ─── Header ─── */
  .ee-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 28px;
  }
  .ee-header h1 {
    font-size: 22px; font-weight: 700; letter-spacing: -.4px; margin: 0 0 4px;
  }
  .ee-header p { font-size: 13px; color: var(--text-muted); margin: 0; }
  .ee-back {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 13px; font-weight: 600; color: var(--text-secondary);
    background: var(--surface); border: 1px solid var(--border);
    padding: 8px 16px; border-radius: 99px; text-decoration: none;
    transition: background .15s, color .15s;
  }
  .ee-back:hover { background: #EEECEA; color: var(--text-primary); text-decoration: none; }

  /* ─── Cards ─── */
  .ee-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 16px;
  }
  .ee-card-head {
    display: flex; align-items: center; gap: 10px;
    padding: 16px 22px; border-bottom: 1px solid var(--border);
    background: var(--surface-2);
  }
  .ee-card-head-icon {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  }
  .ee-card-head h2 { font-size: 14px; font-weight: 700; margin: 0; letter-spacing: -.1px; }
  .ee-card-body { padding: 22px; }

  /* ─── Status pill on header ─── */
  .ee-status-pill {
    margin-left: auto;
    font-size: 11px; font-weight: 700; padding: 3px 11px;
    border-radius: 99px; letter-spacing: .04em; text-transform: uppercase;
  }
  .ee-status-pill.draft      { background: #EEECEA; color: var(--text-secondary); }
  .ee-status-pill.published  { background: var(--green-bg); color: var(--green-text); }
  .ee-status-pill.completed  { background: var(--blue-bg); color: var(--blue-text); }
  .ee-status-pill.cancelled  { background: var(--red-bg); color: var(--red-text); }

  /* ─── Form Fields ─── */
  .ee-field { margin-bottom: 18px; }
  .ee-field:last-child { margin-bottom: 0; }
  .ee-label {
    display: block; font-size: 12px; font-weight: 600;
    text-transform: uppercase; letter-spacing: .06em;
    color: var(--text-muted); margin-bottom: 7px;
  }
  .ee-input, .ee-select, .ee-textarea {
    width: 100%; background: var(--surface-2);
    border: 1px solid var(--border); border-radius: var(--radius-sm);
    padding: 10px 14px; font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px; color: var(--text-primary); outline: none;
    transition: border-color .15s, box-shadow .15s, background .15s;
    appearance: none; -webkit-appearance: none;
  }
  .ee-input:focus, .ee-select:focus, .ee-textarea:focus {
    border-color: var(--border-focus); background: #fff;
    box-shadow: 0 0 0 3px rgba(26,25,23,.07);
  }
  .ee-input.is-invalid { border-color: var(--red); }
  .ee-invalid { font-size: 12px; color: var(--red); margin-top: 5px; }
  .ee-textarea { resize: vertical; min-height: 100px; line-height: 1.6; }
  .ee-select-wrap { position: relative; }
  .ee-select-wrap::after {
    content: ''; position: absolute; right: 13px; top: 50%;
    transform: translateY(-50%); width: 0; height: 0;
    border-left: 5px solid transparent; border-right: 5px solid transparent;
    border-top: 5px solid var(--text-muted); pointer-events: none;
  }

  /* ─── Category Row ─── */
  .ee-cat-row { display: flex; gap: 8px; }
  .ee-cat-row .ee-select-wrap { flex: 1; }
  .ee-add-cat-btn {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--text-primary); color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12px; font-weight: 600; padding: 10px 16px;
    border-radius: var(--radius-sm); border: none; cursor: pointer;
    white-space: nowrap; transition: opacity .15s; flex-shrink: 0;
  }
  .ee-add-cat-btn:hover { opacity: .82; }

  /* ─── Banner Upload ─── */
  .banner-upload-box {
    position: relative; border-radius: var(--radius-sm);
    overflow: hidden; background: var(--surface-2);
    border: 1.5px dashed var(--border);
    transition: border-color .15s; cursor: pointer; margin-bottom: 10px;
  }
  .banner-upload-box:hover { border-color: #aaa; }
  #preview {
    width: 100%; height: 180px; object-fit: cover;
    display: block; border-radius: calc(var(--radius-sm) - 2px);
  }
  .banner-overlay {
    position: absolute; inset: 0; background: rgba(26,25,23,.45);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 6px;
    opacity: 0; transition: opacity .18s;
  }
  .banner-upload-box:hover .banner-overlay { opacity: 1; }
  .banner-overlay span { font-size: 12px; font-weight: 600; color: #fff; }
  #banner { position: absolute; inset: 0; opacity: 0; cursor: pointer; font-size: 0; }
  .banner-hint { font-size: 11px; color: var(--text-muted); text-align: center; }

  /* ─── Submit Bar ─── */
  .ee-submit-bar {
    display: flex; align-items: center; gap: 10px; margin-top: 24px;
  }
  .ee-submit-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--green); color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px; font-weight: 700; padding: 11px 28px;
    border-radius: 99px; border: none; cursor: pointer;
    letter-spacing: -.1px; transition: opacity .15s, transform .15s;
  }
  .ee-submit-btn:hover { opacity: .85; transform: translateY(-1px); }

  /* ─── Modal ─── */
  #addCategoryModal .modal-content {
    font-family: 'Plus Jakarta Sans', sans-serif;
    border: 1px solid rgba(0,0,0,0.08);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.14);
    overflow: hidden;
  }
  #addCategoryModal .modal-header {
    border-bottom: 1px solid var(--border);
    padding: 18px 24px; background: var(--surface-2);
  }
  #addCategoryModal .modal-title { font-size: 15px; font-weight: 700; letter-spacing: -.2px; }
  #addCategoryModal .modal-body { padding: 22px 24px; }
  #addCategoryModal .modal-footer {
    border-top: 1px solid var(--border); padding: 16px 24px; gap: 10px;
  }
  .modal-btn-secondary {
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600;
    color: var(--text-secondary); background: var(--surface-2);
    border: 1px solid var(--border); padding: 9px 20px;
    border-radius: 99px; cursor: pointer; transition: background .15s;
  }
  .modal-btn-secondary:hover { background: #EEECEA; }
  .modal-btn-primary {
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700;
    color: #fff; background: var(--text-primary); border: none;
    padding: 9px 22px; border-radius: 99px; cursor: pointer; transition: opacity .15s;
  }
  .modal-btn-primary:hover { opacity: .82; }
  .modal-btn-primary:disabled { opacity: .5; cursor: not-allowed; }
</style>

<div class="ee-wrap">

  {{-- Header --}}
  <div class="ee-header">
    <div>
      <h1>Edit Event</h1>
      <p>Perbarui informasi, tiket, dan detail event</p>
    </div>
    <a href="{{ route('events.index') }}" class="ee-back">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali
    </a>
  </div>

  <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">

      {{-- LEFT --}}
      <div class="col-md-8">

        {{-- Info Utama --}}
        <div class="ee-card">
          <div class="ee-card-head">
            <div class="ee-card-head-icon" style="background:#E8E6E0">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1A1917" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <h2>Informasi Event</h2>
            @php $statusClass = strtolower($event->status ?? 'draft'); @endphp
            <span class="ee-status-pill {{ $statusClass }}">{{ $event->status ?? 'Draft' }}</span>
          </div>
          <div class="ee-card-body">

            {{-- Title --}}
            <div class="ee-field">
              <label class="ee-label">Judul Event</label>
              <input type="text" name="title"
                class="ee-input @error('title') is-invalid @enderror"
                value="{{ old('title', $event->title) }}"
                placeholder="Masukkan judul event...">
              @error('title')
                <div class="ee-invalid">{{ $message }}</div>
              @enderror
            </div>

            {{-- Category --}}
            <div class="ee-field">
              <label class="ee-label">Kategori</label>
              <div class="ee-cat-row">
                <div class="ee-select-wrap">
                  <select name="category_id" id="category_id" class="ee-select" required>
                    <option value="">— Pilih Kategori —</option>
                    @foreach($categories as $cat)
                      <option value="{{ $cat->id }}" {{ $event->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <button type="button" class="ee-add-cat-btn" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  Kategori Baru
                </button>
              </div>
            </div>

            {{-- Description --}}
            <div class="ee-field">
              <label class="ee-label">Deskripsi</label>
              <textarea name="description" class="ee-textarea" placeholder="Tulis deskripsi event...">{{ old('description', $event->description) }}</textarea>
            </div>

          </div>
        </div>

      </div>

      {{-- RIGHT --}}
      <div class="col-md-4">

        {{-- Banner --}}
        <div class="ee-card">
          <div class="ee-card-head">
            <div class="ee-card-head-icon" style="background:var(--blue-bg)">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1145A0" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
            <h2>Banner Event</h2>
          </div>
          <div class="ee-card-body">
            <div class="banner-upload-box">
              <img id="preview"
                src="{{ $event->banner ? asset('storage/'.$event->banner) : 'https://via.placeholder.com/400x180?text=Upload+Banner' }}"
                alt="preview">
              <div class="banner-overlay">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <span>Ganti Banner</span>
              </div>
              <input type="file" name="banner" id="banner" accept="image/*">
            </div>
            <p class="banner-hint">Kosongkan jika tidak ingin mengganti banner</p>
          </div>
        </div>

        {{-- Detail --}}
        <div class="ee-card">
          <div class="ee-card-head">
            <div class="ee-card-head-icon" style="background:var(--green-bg)">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#0A5E41" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <h2>Detail Event</h2>
          </div>
          <div class="ee-card-body">

            <div class="ee-field">
              <label class="ee-label">Tanggal & Waktu</label>
              <input type="datetime-local" name="event_date" class="ee-input"
                value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i')) }}">
            </div>

            <div class="ee-field">
              <label class="ee-label">Lokasi</label>
              <input type="text" name="location" class="ee-input"
                value="{{ old('location', $event->location) }}"
                placeholder="Nama venue / kota">
            </div>

            <div class="ee-field">
              <label class="ee-label">Total Kuota</label>
              <input type="number" name="total_quota" class="ee-input"
                value="{{ old('total_quota', $event->total_quota) }}"
                placeholder="0">
            </div>

            <div class="ee-field">
              <label class="ee-label">Status</label>
              <div class="ee-select-wrap">
                <select name="status" class="ee-select" required>
                  <option value="">— Pilih Status —</option>
                  <option value="Draft"     {{ $event->status == 'Draft'     ? 'selected' : '' }}>Draft</option>
                  <option value="Published" {{ $event->status == 'Published' ? 'selected' : '' }}>Published</option>
                  <option value="Completed" {{ $event->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                  <option value="Cancelled" {{ $event->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>

    {{-- Submit --}}
    <div class="ee-submit-bar">
      <button type="submit" class="ee-submit-btn">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        Update Event
      </button>
    </div>

  </form>

  {{-- Modal Add Category --}}
  <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCategoryLabel">Tambah Kategori Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addCategoryForm">
            @csrf
            <div class="ee-field">
              <label class="ee-label">Nama Kategori <span style="color:var(--red)">*</span></label>
              <input type="text" class="ee-input" id="new_category_name" name="name"
                placeholder="Contoh: Olahraga, Musik, Seni...">
              <div id="categoryErrorMsg" class="ee-invalid" style="display:none;"></div>
            </div>
          </form>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="modal-btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="modal-btn-primary" id="saveCategoryBtn">Simpan Kategori</button>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection

@section('ExtraJS')
<script>
  document.getElementById('banner').onchange = function() {
    const file = this.files[0];
    if (file) {
      document.getElementById('preview').src = URL.createObjectURL(file);
    }
  }

  document.getElementById('saveCategoryBtn').addEventListener('click', function() {
    const categoryName = document.getElementById('new_category_name').value.trim();
    const errorMsg = document.getElementById('categoryErrorMsg');

    if (!categoryName) {
      errorMsg.textContent = 'Nama kategori harus diisi';
      errorMsg.style.display = 'block';
      return;
    }

    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

    fetch('{{ route("admin.categories.store") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
      },
      body: JSON.stringify({ name: categoryName })
    })
    .then(response => {
      if (!response.ok) return response.json().then(data => { throw data; });
      return response.json();
    })
    .then(data => {
      if (data.success) {
        document.getElementById('addCategoryForm').reset();
        errorMsg.style.display = 'none';

        const select = document.getElementById('category_id');
        const newOption = document.createElement('option');
        newOption.value = data.category_id;
        newOption.textContent = data.category_name;
        newOption.selected = true;
        select.appendChild(newOption);

        const modal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
        modal.hide();
        showAlert('Kategori berhasil ditambahkan!', 'success');
      } else {
        errorMsg.textContent = data.message || 'Gagal menambahkan kategori';
        errorMsg.style.display = 'block';
      }
    })
    .catch(error => {
      if (error.message) {
        errorMsg.textContent = error.message;
      } else if (error.errors && error.errors.name) {
        errorMsg.textContent = error.errors.name[0];
      } else {
        errorMsg.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
      }
      errorMsg.style.display = 'block';
    })
    .finally(() => {
      this.disabled = false;
      this.innerHTML = 'Simpan Kategori';
    });
  });

  function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    const pageHeader = document.querySelector('.ee-header');
    pageHeader.parentNode.insertBefore(alertDiv, pageHeader.nextSibling);
    setTimeout(() => alertDiv.remove(), 5000);
  }
</script>
@endsection