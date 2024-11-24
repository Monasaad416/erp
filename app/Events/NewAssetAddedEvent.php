<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewAssetAddedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $asset,$account,$accountDepreciationsSum,$accountDepreciationExpenses,$supplier_id;
    public function __construct($asset,$account,$accountDepreciationsSum,$accountDepreciationExpenses,$supplier_id)
    {
        $this->asset = $asset;
        $this->account= $account;//حساب الاصل
        $this->accountDepreciationsSum= $accountDepreciationsSum;//حساب مخصص الاهلاك للاصل
        $this->accountDepreciationExpenses= $accountDepreciationExpenses;//حساب مصروفات الاهلاك للاصل
        $this->supplier_id = $supplier_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
