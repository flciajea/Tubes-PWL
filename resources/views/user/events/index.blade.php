@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <!-- Header -->
        <div class="page-header">
            <h4 class="page-title">Daftar Event</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('user.dashboard') }}">
                        <span class="icon-heart"></span>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Event</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Daftar</a>
                </li>
            </ul>
        </div>

        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Terjadi Kesalahan!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('error') }}
            </div>
        @endif

        <!-- Search Section -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('user.events.index') }}" method="GET" class="row g-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Cari event, kategori, atau lokasi..." 
                               name="search" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="category" id="category">
                            <option value="">-- Semua Kategori --</option>
                            @php
                                $categories = \App\Models\Category::all();
                            @endphp
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="row">
            @forelse ($events as $event)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100" style="transition: transform 0.3s, box-shadow 0.3s;">
                        <div class="position-relative overflow-hidden" style="height: 200px;">
                            @if ($event->banner)
                                <img src="{{ asset('storage/' . $event->banner) }}" 
                                     alt="{{ $event->title }}" 
                                     class="card-img-top w-100 h-100" 
                                     style="object-fit: cover;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center w-100 h-100">
                                    <span class="text-white">No Image</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ $event->category->name ?? 'Uncategorized' }}</span>
                            </div>
                            
                            <h5 class="card-title">{{ Str::limit($event->title, 50) }}</h5>
                            
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($event->description, 100) }}
                            </p>
                            
                            <div class="mb-3 small">
                                <div class="mb-2">
                                    <strong>📅 Tanggal:</strong> {{ $event->event_date->format('d M Y H:i') }}
                                </div>
                                <div class="mb-2">
                                    <strong>📍 Lokasi:</strong> {{ Str::limit($event->location, 40) }}
                                </div>
                                <div>
                                    <strong>👤 Organizer:</strong> {{ $event->organizer->name }}
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                <a href="{{ route('user.events.show', $event->id) }}" 
                                   class="btn btn-primary btn-sm w-100">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">Belum Ada Event</h4>
                        <p>Saat ini belum ada event yang tersedia. Silahkan cek kembali nanti.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('ExtraCSS')
<style>
    .card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
</style>
@endsection

@section('ExtraJS')
@endsection
