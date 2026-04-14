@extends('layouts.master')

@section('content')

<style>
  .dash-header { 
    display: flex; 
    align-items: center; 
    justify-content: space-between; 
    margin-bottom: 1.5rem; 
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(0,0,0,0.08);
  }
  .dash-title { font-size: 22px; font-weight: 600; margin: 0; color: #2C2C2A; }
  .dash-sub { font-size: 13px; color: #6c757d; margin: 4px 0 0; }

  .error-alert {
    background: #FFE5E5;
    border: 1px solid #FF4D4D;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    animation: slideDown 0.3s ease;
  }
  .error-alert ul {
    margin: 0;
    padding-left: 1.25rem;
    color: #CC0000;
  }
  .error-alert li {
    font-size: 14px;
    margin-bottom: 4px;
  }

  @keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .form-card {
    background: white;
    border: 1px solid rgba(0,0,0,0.08);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    margin-bottom: 1.5rem;
  }

  .form-card .card-header-custom {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border-bottom: 1px solid rgba(0,0,0,0.06);
  }
  .form-card .card-header-custom h6 {
    font-size: 16px;
    font-weight: 600;
    margin: 0;
    color: #2C2C2A;
  }
  .form-card .card-header-custom p {
    font-size: 13px;
    color: #6c757d;
    margin: 4px 0 0;
  }

  .form-card .card-body {
    padding: 1.5rem;
  }

  .form-label {
    font-size: 13px;
    font-weight: 600;
    color: #2C2C2A;
    margin-bottom: 6px;
    display: block;
  }

  .form-control {
    border: 1.5px solid rgba(0,0,0,0.1);
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 14px;
    transition: all 0.2s ease;
  }
  .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }

  .preview-box {
    width: 100%;
    aspect-ratio: 3/2;
    border-radius: 12px;
    overflow: hidden;
    border: 2px dashed rgba(0,0,0,0.1);
    margin-bottom: 1rem;
    background: #f8f9fa;
    position: relative;
  }
  .preview-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .preview-box::before {
    content: 'Banner Preview';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 13px;
    color: #adb5bd;
    z-index: 0;
  }
  .preview-box img {
    position: relative;
    z-index: 1;
  }

  .ticket-row {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 12px;
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.2s ease;
  }
  .ticket-row:hover {
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  }

  .btn-add-ticket {
    background: linear-gradient(135deg, #1D9E75 0%, #0F6E56 100%);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(29, 158, 117, 0.3);
  }
  .btn-add-ticket:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(29, 158, 117, 0.4);
    color: white;
  }

  .btn-remove {
    background: #FFE5E5;
    border: 1px solid #FF4D4D;
    color: #CC0000;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
  }
  .btn-remove:hover {
    background: #FF4D4D;
    color: white;
  }

  .btn-primary-custom {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px 28px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  }
  .btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
  }

  .btn-secondary-custom {
    background: white;
    border: 1.5px solid #dee2e6;
    color: #6c757d;
    padding: 12px 28px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
  }
  .btn-secondary-custom:hover {
    background: #f8f9fa;
    border-color: #adb5bd;
  }

  .input-group-custom {
    display: flex;
    gap: 8px;
  }
  .input-group-custom .form-control {
    flex: 1;
  }
  .input-group-custom .btn {
    flex-shrink: 0;
  }

  .btn-add-category {
    background: linear-gradient(135deg, #378ADD 0%, #185FA5 100%);
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(55, 138, 221, 0.3);
  }
  .btn-add-category:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(55, 138, 221, 0.4);
    color: white;
  }

  .divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(0,0,0,0.08), transparent);
    margin: 1.5rem 0;
  }

  .section-title {
    font-size: 15px;
    font-weight: 600;
    color: #2C2C2A;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .section-title::before {
    content: '';
    width: 4px;
    height: 18px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 2px;
  }

  .invalid-feedback {
    font-size: 12px;
    color: #CC0000;
    margin-top: 4px;
  }

  .modal-content {
    border: none;
    border-radius: 14px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
  }
  .modal-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border-bottom: 1px solid rgba(0,0,0,0.06);
    padding: 1.25rem 1.5rem;
  }
  .modal-title {
    font-size: 16px;
    font-weight: 600;
    color: #2C2C2A;
  }
</style>

<div class="container">
    <div class="page-inner">

        <!-- HEADER -->
        <div class="dash-header">
            <div>
                <h5 class="dash-title">Create New Event</h5>
                <p class="dash-sub">Buat event baru untuk peserta Anda</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="error-alert">
                <strong>⚠️ Terdapat beberapa kesalahan:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <!-- LEFT COLUMN -->
                <div class="col-md-8">
                    <div class="form-card">
                        <div class="card-header-custom">
                            <h6>📋 Event Information</h6>
                            <p>Informasi dasar tentang event Anda</p>
                        </div>
                        <div class="card-body">

                            <!-- TITLE -->
                            <div class="mb-3">
                                <label class="form-label">Event Title <span class="text-danger">*</span></label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Masukkan judul event yang menarik"
                                    value="{{ old('title') }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- CATEGORY -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                <div class="input-group-custom">
                                    <select name="category_id" id="category_id" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-add-category" data-bs-toggle="modal"
                                        data-bs-target="#addCategoryModal">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
                                </div>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" rows="5" class="form-control" 
                                    placeholder="Deskripsikan event Anda secara detail...">{{ old('description') }}</textarea>
                            </div>

                            <div class="divider"></div>

                            <!-- TICKET TYPES -->
                            <div class="section-title">🎫 Ticket Types</div>

                            <div id="ticket-wrapper">
                                <div class="ticket-row">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class="form-label" style="font-size: 12px;">Tipe Tiket</label>
                                            <select name="ticket_name[]" class="form-control">
                                                <option value="">-- Pilih Tipe --</option>
                                                <option value="VIP">VIP</option>
                                                <option value="Regular">Regular</option>
                                                <option value="Early Bird">Early Bird</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" style="font-size: 12px;">Harga (Rp)</label>
                                            <input type="number" name="ticket_price[]" class="form-control"
                                                placeholder="50000">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" style="font-size: 12px;">Kuota</label>
                                            <input type="number" name="ticket_quota[]" class="form-control"
                                                placeholder="100">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-remove w-100"
                                                onclick="hapusTiket(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-add-ticket mt-2" onclick="tambahTiket()">
                                <i class="fas fa-plus"></i> Tambah Tipe Tiket
                            </button>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-md-4">

                    <!-- BANNER -->
                    <div class="form-card">
                        <div class="card-header-custom">
                            <h6>🖼️ Event Banner</h6>
                            <p>Upload banner menarik untuk event</p>
                        </div>
                        <div class="card-body">
                            <div class="preview-box">
                                <img id="preview" src="https://via.placeholder.com/600x400/f8f9fa/6c757d?text=Event+Banner">
                            </div>
                            <input type="file" name="banner" id="banner" class="form-control" accept="image/*">
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Rekomendasi: 1200x630px, Max 2MB
                            </small>
                        </div>
                    </div>

                    <!-- EVENT DETAILS -->
                    <div class="form-card">
                        <div class="card-header-custom">
                            <h6>📅 Event Details</h6>
                            <p>Informasi waktu dan lokasi</p>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt text-primary"></i> Tanggal & Waktu
                                </label>
                                <input type="datetime-local" name="event_date" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt text-danger"></i> Lokasi
                                </label>
                                <input type="text" name="location" class="form-control" 
                                    placeholder="Contoh: Jakarta Convention Center">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-users text-success"></i> Total Kuota
                                </label>
                                <input type="number" name="total_quota" class="form-control" 
                                    placeholder="500">
                                <small class="text-muted d-block mt-1">
                                    Jumlah maksimal peserta
                                </small>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <!-- ACTION BUTTONS -->
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="fas fa-save"></i> Simpan Event
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary-custom">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

        </form>

    </div>
</div>

<!-- MODAL ADD CATEGORY -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryLabel">
                    <i class="fas fa-plus-circle"></i> Tambah Kategori Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="new_category_name">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="new_category_name" name="name"
                            placeholder="Contoh: Olahraga, Musik, Seni, dll" required>
                        <div id="categoryErrorMsg" class="invalid-feedback" style="display: none;"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="button" class="btn btn-primary-custom" id="saveCategoryBtn">
                    <i class="fas fa-save"></i> Simpan Kategori
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('ExtraJS')
<script>
    // Preview Banner
    document.getElementById('banner').onchange = function() {
        const file = this.files[0];
        if (file) {
            document.getElementById('preview').src = URL.createObjectURL(file);
        }
    }

    // Tambah Tiket
    function tambahTiket() {
        let html = `
        <div class="ticket-row">
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label" style="font-size: 12px;">Tipe Tiket</label>
                    <select name="ticket_name[]" class="form-control" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="VIP">VIP</option>
                        <option value="Regular">Regular</option>
                        <option value="Early Bird">Early Bird</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size: 12px;">Harga (Rp)</label>
                    <input type="number" name="ticket_price[]" class="form-control" placeholder="50000">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-size: 12px;">Kuota</label>
                    <input type="number" name="ticket_quota[]" class="form-control" placeholder="100">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-remove w-100" onclick="hapusTiket(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        `;

        document.getElementById('ticket-wrapper').insertAdjacentHTML('beforeend', html);
    }

    // Hapus Tiket
    function hapusTiket(btn) {
        btn.closest('.ticket-row').remove();
    }

    // Handle Add Category
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

        fetch('{{ route('admin.categories.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: categoryName
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw data;
                    });
                }
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

                    showAlert('✅ Kategori berhasil ditambahkan!', 'success');
                } else {
                    errorMsg.textContent = data.message || 'Gagal menambahkan kategori';
                    errorMsg.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);

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
                this.innerHTML = '<i class="fas fa-save"></i> Simpan Kategori';
            });
    });

    function showAlert(message, type) {
        const colors = {
            'success': { bg: '#E1F5EE', border: '#1D9E75', text: '#0F6E56' },
            'error': { bg: '#FFE5E5', border: '#FF4D4D', text: '#CC0000' }
        };
        const color = colors[type] || colors.success;

        const alertDiv = document.createElement('div');
        alertDiv.style.cssText = `
            background: ${color.bg};
            border: 1px solid ${color.border};
            color: ${color.text};
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideDown 0.3s ease;
        `;
        alertDiv.innerHTML = `
            <span>${message}</span>
            <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:${color.text};font-size:18px;cursor:pointer;">&times;</button>
        `;

        const pageHeader = document.querySelector('.dash-header');
        pageHeader.parentNode.insertBefore(alertDiv, pageHeader.nextSibling);

        setTimeout(() => alertDiv.remove(), 5000);
    }
</script>
@endsection