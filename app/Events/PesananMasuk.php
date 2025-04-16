<?php

namespace App\Events;

use App\Models\Dapur;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PesananMasuk implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pesanan;

    public function __construct(Dapur $pesanan)
    {
        // Memastikan relasi 'menu' dan 'meja' sudah termuat
        $this->pesanan = $pesanan->load('menu', 'meja');
        Log::info('Event PesananMasuk dikirim', ['pesanan' => $pesanan]);
    }

    public function broadcastOn()
    {
        // Broadcast ke channel "dapur"
        return new Channel('dapur');
    }

    public function broadcastAs()
    {
        return 'pesanan.masuk';
    }
}
