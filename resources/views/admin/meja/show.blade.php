<!-- resources/views/admin/meja/show.blade.php -->
@extends('layouts.admin')

@section('content')
    <h1>Detail Meja: {{ $meja->nomor }}</h1>
    <p>QR Code untuk pemesanan:</p>
    <img src="{!! QrCode::size(200)->generate(url('/pesan/'.$meja->id)) !!}" alt="QR Code Meja">
@endsection
