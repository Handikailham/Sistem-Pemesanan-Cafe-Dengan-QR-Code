<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order; // pastikan Model Order ada atau sesuaikan

class NewOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Buat instance event.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Channel mana event ini akan disiarkan.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('kitchen');
    }

    /**
     * Optional: Nama event yang akan diterima di sisi JavaScript.
     */
    public function broadcastAs()
    {
        return 'new.order';
    }
}
