@extends('layouts.master')

@section('content')
<div class="container">
    <div class="page-inner">

        <!-- HEADER -->
        <div class="page-header">
            <h3 class="fw-bold mb-3">Create Event</h3>
        </div>

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
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">-- Pilih Category --</option>
                                    
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                    
                                </select>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" rows="4"
                                    class="form-control">{{ old('description') }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="col-md-4">

                    <!-- BANNER -->
                    <div class="card shadow-sm">
                        <div class="card-body text-center">

                            <img id="preview"
                                src="https://via.placeholder.com/300x200"
                                class="img-fluid rounded mb-3">

                            <input type="file" name="banner" id="banner"
                                class="form-control">

                        </div>
                    </div>

                    <!-- DETAIL -->
                    <div class="card shadow-sm mt-3">
                        <div class="card-body">

                            <div class="mb-3">
                                <label>Tanggal</label>
                                <input type="datetime-local" name="event_date"
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Location</label>
                                <input type="text" name="location"
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Quota</label>
                                <input type="number" name="total_quota"
                                    class="form-control">
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

@section('ExtraJS')
<script>
document.getElementById('banner').onchange = function () {
    const file = this.files[0];
    if (file) {
        document.getElementById('preview').src = URL.createObjectURL(file);
    }
}
</script>
@endsection