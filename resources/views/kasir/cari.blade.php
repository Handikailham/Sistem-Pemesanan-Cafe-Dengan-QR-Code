<!DOCTYPE html>
<html>
<head>
    <title>Cari Kode Pembayaran</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .box { max-width: 400px; margin: auto; background: #f9f9f9; padding: 20px; border-radius: 8px; }
        input, button { width: 100%; padding: 10px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Cari Kode Pembayaran</h2>

        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <form action="{{ route('kasir.cari') }}" method="POST">
            @csrf
            <input type="text" name="kode_pembayaran" placeholder="Masukkan kode pembayaran" required>
            <button type="submit">Cari</button>
        </form>
    </div>
</body>
</html>
