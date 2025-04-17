<?php
namespace App\Events;

use App\Models\Dapur;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PesananMasuk implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pesanan;

    public function __construct(Dapur $pesanan)
    {
        // load relasi
        $this->pesanan = $pesanan->load('menu','meja');
    }

    public function broadcastOn()
    {
        return new Channel('dapur');
    }

    public function broadcastAs()
    {
        return 'pesanan.masuk';
    }

    /**
     * Override payload agar include relasi.
     */
    public function broadcastWith()
    {
        return [
            // kita bungkus lagi ke dalam key 'pesanan'
            'pesanan' => $this->pesanan->toArray(),
        ];
    }
}
