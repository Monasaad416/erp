<?php

namespace App\Notifications;

use App\Models\Store;
use App\Models\Branch;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NewStoreTransaction extends Notification
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $fromStore = Store::where('id',$this->trans->from_store_id)->first();
        $fromBranch = Branch::where('id',$fromStore->branch_id)->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->first();
        $toStore = Store::where('id',$this->trans->to_store_id)->first();
        $toBranch = Branch::where('id',$toStore->branch_id)->select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->first();
        return [
            'title' => 'تحويل مخزني جديد',
            'action' => 'store/transaction/items/'. $this->trans->trans_num,
            'body' => ' تم عمل تحويل مخزني من  '. $fromBranch->name .' إلي  /'.$toBranch->name . 'يرجي فحصه من قبل الفرع المحول إليه وتحديد المقبول',
        ];
    }
}
