<?php

namespace App\Events;

use App\Models\SupplierInvoice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SuppInvoicePartiallyReturnedEvent 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $invoice,$item,$bankId,$totalReturnPrice;
    public function __construct(SupplierInvoice $suppInvoice,$bankId,$item,$totalReturnPrice)
    {
        //dd($suppInvoice);
        $this->invoice = $suppInvoice;
        $this->bankId = $bankId;
        $this->item = $item;
        $this->totalReturnPrice = $totalReturnPrice;
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
