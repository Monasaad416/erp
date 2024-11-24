<?php

namespace App\Events;

use App\Models\SupplierReturn;
use App\Models\SupplierInvoice;
use App\Models\SupplierInvoiceItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class SuppItemReturnedEvent implements ShouldHandleEventsAfterCommit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    
    public $invoice,$returnItem,$bankId,$totalReturnPrice;
    public function __construct(SupplierInvoice $suppInvoice,$bankId,$totalReturnPrice,$returnItem)
    {
        $this->invoice = $suppInvoice;
        $this->bankId = $bankId;
        $this->returnItem = $returnItem;
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
