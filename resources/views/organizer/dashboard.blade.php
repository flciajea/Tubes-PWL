@extends('layouts.master')

@section('content')

<a href="{{ route('organizer.scan') }}" class="btn btn-primary">
    🎫 Scan QR Tiket
</a>

<form method="POST" action="/logout">
@csrf
<button type="submit">Logout</button>
</form>

@endsection