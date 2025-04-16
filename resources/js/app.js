import './bootstrap';

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = require('pusher-js');
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY, // atau bisa kamu langsung tulis '{{ env("PUSHER_APP_KEY") }}' di blade
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

// Mendengarkan event pada channel "dapur"
window.Echo.channel('dapur')
    .listen('.pesanan.masuk', (e) => {
        console.log('Pesanan baru masuk:', e);
        // Gunakan data e.pesanan untuk update tampilan. Contoh:
        let daftarPesanan = document.getElementById('daftar-pesanan');
        if (daftarPesanan) {
            // Asumsikan struktur element sama dengan data yang kamu butuhkan
            let newOrder = document.createElement('div');
            newOrder.innerHTML = `<strong>Meja #${e.pesanan.meja.nomor}</strong> - ${e.pesanan.menu.nama} (${e.pesanan.jumlah})`;
            // Memasukkan data baru di bagian atas list
            daftarPesanan.prepend(newOrder);
        }
    });
