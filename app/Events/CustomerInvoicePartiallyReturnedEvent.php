<?php

namespace App\Events;

use App\Models\CustomerInvoice;
use App\Models\CustomerReturn;
use App\Models\SupplierInvoice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CustomerInvoicePartiallyReturnedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $invoiceReturn,$item,$price,$tax;
    public function __construct(CustomerReturn $invoiceReturn , $tax,$price,$item)
    {
        $this->invoiceReturn = $invoiceReturn;
        $this->tax = $tax;
        $this->price = $price;
        $this->item = $item;
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
