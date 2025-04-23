<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cari Kode Pembayaran</title>
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
      class="min-h-screen bg-cover bg-center flex items-center justify-center"
      style="background-image: url('{{ asset('images/geolig.jpg') }}');"
    >
        <div class="bg-white bg-opacity-80 rounded-xl p-8 shadow-lg max-w-md w-full mx-4">
            <h2 class="text-xl font-semibold mb-4 flex items-center justify-center text-gray-800">
                <svg class="w-6 h-6 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 
                        0 7 7 0 0114 0z" />
                </svg>
                Cari Kode Pembayaran
            </h2>

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-3">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('kasir.cari') }}" method="POST" class="space-y-4">
                @csrf
                <input 
                    type="text" 
                    name="kode_pembayaran" 
                    placeholder="Masukkan kode pembayaran" 
                    required 
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button 
                    type="submit" 
                    class="w-full bg-yellow-500 hover:bg-yellow-500 text-white font-semibold py-2 rounded"
                >
                    Cari
                </button>
            </form>
        </div>
    </div>
</body>
</html>
