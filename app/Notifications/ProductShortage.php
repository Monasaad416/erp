<?php

namespace App\Notifications;

use App\Models\Branch;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class ProductShortage extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $product,$branch_id;
    public function __construct($product,$branch_id)
    {
        $this->product = $product;
        $this->branch_id = $branch_id;
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
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $branch = Branch::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$this->branch_id)->first();
        return [
            'title' => 'تنبية عن نقص مخزون منتج',
            'action' => 'reports/products-shortcomings',
            'body' => 'لقد وصل رصيد المنتج '. $this->product->name_ar .'بفرع /'.$branch->name . ' للحد الادني  ',
        ];
    }
}
