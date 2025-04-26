<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome | ScanBrew Cafe</title>
  <!-- Tailwind CSS via CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

  <!-- Navbar -->
  <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      <!-- Logo + Nama -->
      <a href="#" class="flex items-center">
        <img class="h-8 w-8 mr-2" src="{{ asset('images/scanbrewcafe.png') }}" alt="Logo ScanBrew">
        <span class="text-xl font-bold text-yellow-500">ScanBrew Café</span>
      </a>

      <!-- Menu Links -->
      <div class="space-x-6 flex">
        <a href="#"
           class="border-b-2 border-transparent pb-0.5 text-gray-800 hover:text-yellow-500 hover:border-yellow-500 transition-colors">
          Home
        </a>
        <a href="#"
           class="border-b-2 border-transparent pb-0.5 text-gray-800 hover:text-yellow-500 hover:border-yellow-500 transition-colors">
          Pesan
        </a>
        <a href="#"
           class="border-b-2 border-transparent pb-0.5 text-gray-800 hover:text-yellow-500 hover:border-yellow-500 transition-colors">
          Lokasi
        </a>
        <a href="#"
           class="border-b-2 border-transparent pb-0.5 text-gray-800 hover:text-yellow-500 hover:border-yellow-500 transition-colors">
          Contact
        </a>
      </div>
    </div>
  </div>
</nav>


<main class="relative flex items-center justify-between h-screen overflow-hidden bg-white">
  <!-- Background utama -->
  <div class="absolute bottom-20 right-1/4 w-60 h-60 border-2 border-yellow-300 rounded-full opacity-20"></div>
  <div class="absolute top-1/3 right-0 w-32 h-32 bg-yellow-300 opacity-30 rounded-full"></div>

  <!-- KIRI: teks -->
  <div class="relative z-10 w-1/2 px-8 flex flex-col justify-center">
    <div class="text-3xl md:text-4xl text-yellow-500 font-bold mb-2">HEY!</div>
    <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 leading-tight mb-4">
      ENJOY YOUR TIME
    </h1>
    <p class="text-base md:text-lg text-gray-700 mb-6">
      Santai sejenak, nikmati aroma dan cita rasa kopi spesial kami.
    </p>
    <div class="text-xl font-semibold text-gray-900">@SCANBREWCAFE</div>
  </div>

  <!-- KANAN: gambar tangan + buletan -->
  <div class="relative z-10 w-1/2 flex items-center justify-center pr-8">
    <div class="relative">
      <img src="{{ asset('images/tangan.png') }}" alt="Coffee Cup" class="h-[500px] object-contain" />
      
      <!-- Buletan solid warna di sekitar tangan -->
      <div class="absolute -top-16 -left-16 w-24 h-24 bg-yellow-300 rounded-full opacity-60"></div>
      <div class="absolute top-4 -right-20 w-20 h-20 bg-yellow-300 rounded-full opacity-60"></div>
      <div class="absolute bottom-8 -left-10 w-16 h-16 bg-yellow-300 rounded-full opacity-60"></div>
      <div class="absolute bottom-16 right-0 w-20 h-20 bg-yellow-300 rounded-full opacity-60"></div>
    </div>
  </div>
</main>

<!-- Section Cara Pemesanan: padding-top diperkecil -->
<section class="pt-8 pb-16">
  <div class="max-w-4xl mx-auto text-center mb-12">
    <h2 class="text-3xl font-extrabold text-gray-900">Cara Pemesanan</h2>
    <p class="text-gray-600 mt-2">Mudah dan cepat – ikuti langkah berikut!</p>
  </div>

  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 px-4" x-data>
    
    <!-- Step 1 -->
    <div class="relative bg-white rounded-2xl p-6 border-2 border-yellow-300 shadow-sm hover:shadow-lg transition">
      <div class="w-10 h-10 bg-yellow-300 text-white rounded-full flex items-center justify-center font-bold absolute -top-5 left-1/2 transform -translate-x-1/2">
        1
      </div>
      <div class="mt-8 flex justify-center">
        <i data-feather="map-pin" class="w-8 h-8 text-yellow-500"></i>
      </div>
      <div class="mt-4 text-center">
        <h3 class="text-lg font-semibold text-gray-800">Datang ke Café</h3>
        <p class="text-sm text-gray-600">Kunjungi ScanBrew Café terdekat.</p>
      </div>
    </div>

    <!-- Step 2 -->
    <div class="relative bg-white rounded-2xl p-6 border-2 border-yellow-300 shadow-sm hover:shadow-lg transition">
      <div class="w-10 h-10 bg-yellow-300 text-white rounded-full flex items-center justify-center font-bold absolute -top-5 left-1/2 transform -translate-x-1/2">
        2
      </div>
      <div class="mt-8 flex justify-center">
        <i data-feather="grid" class="w-8 h-8 text-yellow-500"></i>
      </div>
      <div class="mt-4 text-center">
        <h3 class="text-lg font-semibold text-gray-800">Duduk di Meja</h3>
        <p class="text-sm text-gray-600">Pilih meja nyaman dan duduk santai.</p>
      </div>
    </div>

    <!-- Step 3 -->
    <div class="relative bg-white rounded-2xl p-6 border-2 border-yellow-300 shadow-sm hover:shadow-lg transition">
      <div class="w-10 h-10 bg-yellow-300 text-white rounded-full flex items-center justify-center font-bold absolute -top-5 left-1/2 transform -translate-x-1/2">
        3
      </div>
      <div class="mt-8 flex justify-center">
        <i data-feather="camera" class="w-8 h-8 text-yellow-500"></i>
      </div>
      <div class="mt-4 text-center">
        <h3 class="text-lg font-semibold text-gray-800">Scan QR Code</h3>
        <p class="text-sm text-gray-600">Arahkan kamera ke QR di meja Anda.</p>
      </div>
    </div>

    <!-- Step 4 -->
    <div class="relative bg-white rounded-2xl p-6 border-2 border-yellow-300 shadow-sm hover:shadow-lg transition">
      <div class="w-10 h-10 bg-yellow-300 text-white rounded-full flex items-center justify-center font-bold absolute -top-5 left-1/2 transform -translate-x-1/2">
        4
      </div>
      <div class="mt-8 flex justify-center">
        <i data-feather="dollar-sign" class="w-8 h-8 text-yellow-500"></i>
      </div>
      <div class="mt-4 text-center">
        <h3 class="text-lg font-semibold text-gray-800">Bayar ke Kasir</h3>
        <p class="text-sm text-gray-600">Selesaikan pembayaran di kasir kami.</p>
      </div>
    </div>

  </div>
</section>


<!-- Section Alamat Café -->
<section class="py-20 bg-white">
  <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-12 px-6">

    <!-- Gambar Café -->
    <div class="flex-1 flex justify-center">
      <div class="relative">
        <img src="{{ asset('images/tokocafe.png') }}" alt="ScanBrew Café" class="w-full max-w-sm rounded-3xl shadow-lg">
        <!-- Hiasan Bulat -->
        <div class="absolute -top-6 -left-6 w-16 h-16 bg-yellow-300 rounded-full opacity-30"></div>
        <div class="absolute bottom-0 -right-8 w-20 h-20 bg-yellow-300 rounded-full opacity-20"></div>
      </div>
    </div>

    <!-- Keterangan Alamat -->
    <div class="flex-1">
      <div class="text-center md:text-left">
        <div class="flex items-center justify-center md:justify-start mb-4">
          <div class="w-14 h-14 bg-yellow-300 rounded-full flex items-center justify-center shadow-md">
            <i data-feather="coffee" class="w-7 h-7 text-white"></i>
          </div>
        </div>
        <h2 class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
          ScanBrew Café Depok
        </h2>
        <p class="text-lg text-gray-700 mb-6">
          Nongkrong lebih seru di tempat kami!  
          Nikmati suasana cozy sambil menyeruput kopi favoritmu.
        </p>
        <div class="bg-yellow-100 p-4 rounded-xl inline-block">
          <p class="text-lg font-semibold text-yellow-600">
            📍 Jl. Margonda Raya No.123, Depok, Jawa Barat
          </p>
          <p class="text-gray-600 mt-2 text-sm">
            Buka Setiap Hari | 08.00 - 22.00 WIB
          </p>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Footer – White BG with Yellow Top Border -->
<footer class="bg-white border-t-4 border-yellow-500 text-gray-700 py-12">
  <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">

    <!-- Logo & Tagline -->
    <div class="flex flex-col items-center md:items-start">
      <div class="flex items-center mb-3">
        <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center">
          <i data-feather="coffee" class="w-5 h-5 text-white"></i>
        </div>
        <span class="ml-2 text-xl font-bold">ScanBrew Café</span>
      </div>
      <p class="text-sm">
        Nongkrong dan ngopi nyaman di Depok—satu-satunya gerai kami!
      </p>
    </div>

    <!-- Navigation -->
    <div class="flex flex-col items-center">
      <h4 class="font-semibold mb-3">Explore</h4>
      <ul class="space-y-2 text-sm">
        <li><a href="#" class="flex items-center hover:text-yellow-500"><i data-feather="home" class="w-4 h-4 mr-2"></i>Home</a></li>
        <li><a href="#" class="flex items-center hover:text-yellow-500"><i data-feather="menu" class="w-4 h-4 mr-2"></i>Menu</a></li>
        <li><a href="#" class="flex items-center hover:text-yellow-500"><i data-feather="shopping-cart" class="w-4 h-4 mr-2"></i>Order</a></li>
        <li><a href="#" class="flex items-center hover:text-yellow-500"><i data-feather="map-pin" class="w-4 h-4 mr-2"></i>Location</a></li>
      </ul>
    </div>

    <!-- Contact Info -->
    <div class="flex flex-col items-center">
      <h4 class="font-semibold mb-3">Contact</h4>
      <p class="text-sm flex items-center"><i data-feather="phone" class="w-4 h-4 mr-2"></i>(021) 1234-5678</p>
      <p class="text-sm flex items-center mt-2"><i data-feather="mail" class="w-4 h-4 mr-2"></i>info@scanbrew.id</p>
      <p class="text-sm flex items-center mt-2"><i data-feather="clock" class="w-4 h-4 mr-2"></i>08.00–22.00 WIB</p>
    </div>

    <!-- Social Media -->
    <div class="flex flex-col items-center md:items-end">
      <h4 class="font-semibold mb-3">Follow Us</h4>
      <div class="flex space-x-3">
        <a href="#" class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center hover:bg-yellow-600 transition">
          <i data-feather="facebook" class="w-4 h-4 text-white"></i>
        </a>
        <a href="#" class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center hover:bg-yellow-600 transition">
          <i data-feather="instagram" class="w-4 h-4 text-white"></i>
        </a>
        <a href="#" class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center hover:bg-yellow-600 transition">
          <i data-feather="twitter" class="w-4 h-4 text-white"></i>
        </a>
      </div>
    </div>

  </div>

  <div class="mt-8 text-center text-xs text-gray-500">
    © 2025 ScanBrew Café. All rights reserved.
  </div>

  
</footer>



<script src="https://unpkg.com/feather-icons"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    feather.replace();
  });
</script>



</body>
</html>
