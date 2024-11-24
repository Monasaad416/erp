<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FinancialYearClosingEntryEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $salesBranchIncome,$salesAssetsBranchIncome,$purchasesBranchIncome , $salesReturnsBranchIncome , $waterBranchIncome , $electricityBranchIncome , $phoneBranchIncome, $rentBranchIncome, $internetBranchIncome, $stationryBranchIncome, $transportationBranchIncome, $printersBranchIncome,
        $salariesBranchIncome , $buildingsBranchDepIncome , $carsBranchDepIncome , $computersBranchDepIncome , $furnitureBranchDepIncome , $POSDevicesDepBranchIncome , $taxBranchIncome;
    public function __construct($salesBranchIncome,$salesAssetsBranchIncome,$purchasesBranchIncome , $salesReturnsBranchIncome , $waterBranchIncome , $electricityBranchIncome , $phoneBranchIncome, $rentBranchIncome, $internetBranchIncome, $stationryBranchIncome, $transportationBranchIncome, $printersBranchIncome,
        $salariesBranchIncome , $buildingsBranchDepIncome , $carsBranchDepIncome , $computersBranchDepIncome , $furnitureBranchDepIncome , $POSDevicesDepBranchIncome , $taxBranchIncome)
    {
        $this->salesBranchIncome = $salesBranchIncome ;
        $this->salesAssetsBranchIncome = $salesAssetsBranchIncome ;
        $this->purchasesBranchIncome = $purchasesBranchIncome ;
        $this->salesReturnsBranchIncome = $salesReturnsBranchIncome ;
        $this->waterBranchIncome = $waterBranchIncome ;
        $this->electricityBranchIncome = $electricityBranchIncome ;
        $this->phoneBranchIncome = $phoneBranchIncome;
        $this->rentBranchIncome = $rentBranchIncome;
        $this->internetBranchIncome = $internetBranchIncome;
        $this->stationryBranchIncome = $stationryBranchIncome;
        $this->transportationBranchIncome = $transportationBranchIncome;
        $this->printersBranchIncome = $printersBranchIncome;
        $this->salariesBranchIncome = $salariesBranchIncome ;
        $this->buildingsBranchDepIncome = $buildingsBranchDepIncome;
        $this->carsBranchDepIncome = $carsBranchDepIncome;
        $this->computersBranchDepIncome = $computersBranchDepIncome;
        $this->furnitureBranchDepIncome = $furnitureBranchDepIncome;
        $this->POSDevicesDepBranchIncome = $POSDevicesDepBranchIncome;
        $this->taxBranchIncome = $taxBranchIncome;
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
