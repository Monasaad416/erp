<?php

namespace App\Events;

use App\Models\CustomerDebitNote;
use App\Models\CustomerInvoice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CustomerNewDebitNoteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $customerDebitNote,$tax,$price,$newInvoiceItem;
    public function __construct(CustomerDebitNote $customerDebitNote, $tax,$price,$newInvoiceItem)
    {
        $this->customerDebitNote = $customerDebitNote;
        $this->tax = $tax;
        $this->price = $price;
        $this->newInvoiceItem = $newInvoiceItem;
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
