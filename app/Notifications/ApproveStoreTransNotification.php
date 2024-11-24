<?php

namespace App\Notifications;

use App\Models\Store;
use App\Models\Branch;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ApproveStoreTransNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $trans;
    public function __construct($trans)
    {
        $this->trans = $trans;
    }



    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
  public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $fromStore = Store::where('id',$this->trans->from_store_id)->first();
        $fromBranch = Branch::where('id',$fromStore->branch_id)->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->first();
        $toStore = Store::where('id',$this->trans->to_store_id)->first();
        $toBranch = Branch::where('id',$toStore->branch_id)->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->first();
        return [
            'title' => 'تم فحص التحويل المخزني',
            'action' => 'store/transaction/items/'. $this->trans->trans_num,
            'body' => 'تم  فحص التحويل المخزني  من   '. $fromBranch->name .'إلي  /'.$toBranch->name . 'و تحديد المقبول',
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
}
