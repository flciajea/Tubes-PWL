@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="page-inner">

            <!-- HEADER -->
            <div class="page-header">
                <h3 class="fw-bold mb-3">Create Event</h3>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
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

                    <!-- LEFT -->
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-body">

                                <!-- TITLE -->
                                <div class="mb-3">
                                    <label class="form-label">Event Title</label>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- CATEGORY -->
                                <!-- Menambahkan dropdown kategori dengan data dinamis dari database -->
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <div class="input-group">
                                        <select name="category_id" id="category_id" class="form-control" required>
                                            <option value="">-- Pilih Category --</option>

                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach

                                        </select>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>

                                <!-- DESCRIPTION -->
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" rows="4"
                                        class="form-control">{{ old('description') }}</textarea>
                                </div>
                                <hr>

                                <h5 class="mt-3">Ticket Types</h5>

                                <div id="ticket-wrapper">

                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <select name="ticket_name[]" class="form-control">
                                                <option value="">-- Pilih Tipe --</option>
                                                <option value="VIP">VIP</option>
                                                <option value="Regular">Regular</option>
                                                <option value="Early Bird">Early Bird</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="ticket_price[]" class="form-control"
                                                placeholder="Harga">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="ticket_quota[]" class="form-control"
                                                placeholder="Quota">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger"
                                                onclick="hapusTiket(this)">X</button>
                                        </div>
                                    </div>

                                </div>

                                <button type="button" class="btn btn-sm btn-success mt-2" onclick="tambahTiket()">
                                    + Tambah Tiket
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div class="col-md-4">

                        <!-- BANNER -->
                        <div class="card shadow-sm">
                            <div class="card-body text-center">

                                <img id="preview" src="https://via.placeholder.com/300x200" class="img-fluid rounded mb-3">

                                <input type="file" name="banner" id="banner" class="form-control">

                            </div>
                        </div>

                        <!-- DETAIL -->
                        <div class="card shadow-sm mt-3">
                            <div class="card-body">

                                <div class="mb-3">
                                    <label>Tanggal</label>
                                    <input type="datetime-local" name="event_date" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Location</label>
                                    <input type="text" name="location" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label>Quota</label>
                                    <input type="number" name="total_quota" class="form-control">
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                <!-- BUTTON -->
                <div class="mt-3">
                    <button class="btn btn-primary">
                        Simpan Event
                    </button>

                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>
@endsection

<!-- MODAL ADD CATEGORY -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryLabel">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="new_category_name">
                            <strong>Nama Kategori <span class="text-danger">*</span></strong>
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="new_category_name" 
                               name="name" 
                               placeholder="Contoh: Olahraga, Musik, Seni, dll"
                               required>
                        <div id="categoryErrorMsg" class="invalid-feedback" style="display: none;"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveCategoryBtn">Simpan Kategori</button>
            </div>
        </div>
    </div>
</div>

@section('ExtraJS')
    <script>
        document.getElementById('banner').onchange = function () {
            const file = this.files[0];
            if (file) {
                document.getElementById('preview').src = URL.createObjectURL(file);
            }
        }
        
        function tambahTiket() {
            let html = `
            <div class="row mb-2">
                <div class="col-md-4">
                    <select name="ticket_name[]" class="form-control" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="VIP">VIP</option>
                        <option value="Regular">Regular</option>
                        <option value="Early Bird">Early Bird</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" name="ticket_price[]" class="form-control" placeholder="Harga">
                </div>
                <div class="col-md-3">
                    <input type="number" name="ticket_quota[]" class="form-control" placeholder="Quota">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger" onclick="hapusTiket(this)">X</button>
                </div>
            </div>
            `;

            document.getElementById('ticket-wrapper').insertAdjacentHTML('beforeend', html);
        }

        function hapusTiket(btn) {
            btn.parentElement.parentElement.remove();
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
            
            // Disable button saat proses
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
            
            // AJAX Request
            fetch('{{ route("admin.categories.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
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
                    // Clear form
                    document.getElementById('addCategoryForm').reset();
                    errorMsg.style.display = 'none';
                    
                    // Tambah option baru ke dropdown
                    const select = document.getElementById('category_id');
                    const newOption = document.createElement('option');
                    newOption.value = data.category_id;
                    newOption.textContent = data.category_name;
                    newOption.selected = true;
                    select.appendChild(newOption);
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
                    modal.hide();
                    
                    // Show success message
                    showAlert('Kategori berhasil ditambahkan!', 'success');
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
                this.innerHTML = 'Simpan Kategori';
            });
        });

        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            const pageHeader = document.querySelector('.page-header');
            pageHeader.parentNode.insertBefore(alertDiv, pageHeader.nextSibling);
            
            setTimeout(() => alertDiv.remove(), 5000);
        }
    </script>
@endsection