<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Berhasil</title>
    <style>
        body { font-family: sans-serif; padding: 20px; text-align: center; }
        .box { max-width: 400px; margin: auto; background: #e0ffe0; padding: 20px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Transaksi Berhasil!</h2>
        <p><strong>Total:</strong> Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
        <p><strong>Dibayar:</strong> Rp {{ number_format($jumlah_bayar, 0, ',', '.') }}</p>
        <p><strong>Kembalian:</strong> Rp {{ number_format($kembalian, 0, ',', '.') }}</p>
        <br>
        <a href="{{ route('kasir.index') }}">Kembali ke pencarian</a>
    </div>
</body>
</html>
