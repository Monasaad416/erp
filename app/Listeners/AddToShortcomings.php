<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\ShortComing;
use App\Notifications\ProductShortage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddToShortcomings
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $product = $event->product;
        $branch_id = $event->branch_id;
        $code = $event->code;

        $qty = 0;
        
        $qty = $branch_id === 1 ? $product->alert_main_branch : $product->alert_branch;

        ShortComing::create([
            'product_id' => $product->id,
            'name_en' => $product->name_en,
            'name_ar' => $product->name_ar,
            'serial_num' => $product->serial_num,
            'category_id' => $product->category_id,
            'unit_id' => $product->unit_id,
            'supplier_id' => $product->supplier_id,
            'branch_id' => $branch_id,
            'code' => $code,
            'qty' => $qty
        ]);


        $user = User::where('roles_name','سوبر-ادمن')->first();
        $user->notify(new ProductShortage($product,$branch_id));
    }
}
