// Pastikan Echo sudah didefinisikan dalam bootstrap.js
import './bootstrap';
window.Echo.channel('dapur')
    .listen('.pesanan.masuk', (data) => {
        console.log('Pesanan baru diterima:', data.dapurEntry);
        // Update UI: misalnya tambahkan entry baru ke dalam daftar pesanan di dapur
        const ordersList = document.getElementById('orders-list');
        if (ordersList) {
            const li = document.createElement('li');
            // Ubah properti ini sesuai kebutuhan data dari dapurEntry
            li.innerText = `Order ID: ${data.dapurEntry.order_id} - Menu ID: ${data.dapurEntry.menu_id} - Jumlah: ${data.dapurEntry.jumlah}`;
            ordersList.appendChild(li);
        }
    });
