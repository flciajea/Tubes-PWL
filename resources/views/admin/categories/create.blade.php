@extends('layouts.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <!-- Header -->
        <div class="page-header">
            <h3 class="fw-bold mb-3">Tambah Kategori Baru</h3>
        </div>

        <!-- Form -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf

                            <!-- Nama Kategori -->
                            <div class="mb-3">
                                <label class="form-label" for="name">
                                    <strong>Nama Kategori <span class="text-danger">*</span></strong>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       placeholder="Contoh: Olahraga, Musik, Seni, dll"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Kategori
                                </button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-info-circle text-info"></i> Informasi
                        </h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Nama Kategori:</strong> Nama unik untuk kategori event Anda
                            </li>
                            <li class="mb-2">
                                <strong>Contoh Kategori:</strong>
                                <ul class="mt-2">
                                    <li>Olahraga</li>
                                    <li>Musik & Konser</li>
                                    <li>Seni & Budaya</li>
                                    <li>Teknologi</li>
                                    <li>Pendidikan</li>
                                    <li>Bisnis & Workshop</li>
                                </ul>
                            </li>
                            <li>
                                <strong>Catatan:</strong> Setiap kategori baru akan otomatis tersedia di filter pencarian user
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
