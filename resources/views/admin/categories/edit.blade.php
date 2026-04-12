@extends('layouts.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <!-- Header -->
        <div class="page-header">
            <h3 class="fw-bold mb-3">Edit Kategori</h3>
        </div>

        <!-- Form -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama Kategori -->
                            <div class="mb-3">
                                <label class="form-label" for="name">
                                    <strong>Nama Kategori <span class="text-danger">*</span></strong>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       placeholder="Masukkan nama kategori"
                                       value="{{ old('name', $category->name) }}"
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
                                    <i class="fas fa-save"></i> Update Kategori
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
                            <i class="fas fa-info-circle text-info"></i> Informasi Kategori
                        </h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Kategori:</strong> {{ $category->name }}
                            </li>
                            <li class="mb-2">
                                <strong>Total Event:</strong> {{ $category->events()->count() }} event
                            </li>
                            <li class="mb-2">
                                <strong>Dibuat:</strong> {{ $category->created_at->format('d M Y H:i') }}
                            </li>
                            <li>
                                <strong>Terakhir Update:</strong> {{ $category->updated_at->format('d M Y H:i') }}
                            </li>
                        </ul>

                        @if ($category->events()->count() > 0)
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-exclamation-circle"></i>
                                Kategori ini memiliki {{ $category->events()->count() }} event. 
                                Perubahan nama akan berlaku untuk semua event di kategori ini.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
