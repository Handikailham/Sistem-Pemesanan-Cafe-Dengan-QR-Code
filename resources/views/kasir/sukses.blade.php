<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
    </style>
</head>
<body>
    <div 
        class="min-h-screen bg-cover bg-center flex items-center justify-center px-4"
        style="background-image: url('{{ asset('images/geolig.jpg') }}');"
    >
        <div class="bg-white bg-opacity-90 shadow-2xl rounded-2xl p-8 max-w-md w-full text-center">
            <div class="flex justify-center mb-4">
                <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4-4M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10z" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Transaksi Berhasil</h2>
            <p class="text-gray-600 mb-6">Pembayaran telah diterima dengan sukses.</p>

            <div class="bg-gray-100 rounded-lg p-4 text-left text-sm text-gray-700 space-y-2">
                <div class="flex justify-between">
                    <span class="font-medium">Total:</span>
                    <span>Rp {{ number_format($totalTagihan, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Dibayar:</span>
                    <span>Rp {{ number_format($jumlah_bayar, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Kembalian:</span>
                    <span>Rp {{ number_format($kembalian, 0, ',', '.') }}</span>
                </div>
            </div>

            <a href="{{ route('kasir.index') }}" class="mt-6 inline-block w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                🔄 Kembali ke Pencarian
            </a>
        </div>
    </div>
</body>
</html>
