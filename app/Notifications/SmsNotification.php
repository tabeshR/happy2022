<?php

namespace App\Notifications;

use App\Notifications\Channels\SmsIr;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SmsNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $code;
    private $phone;



    public function __construct($code,$phone)
    {
        $this->code = $code;
        $this->phone = $phone;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsIr::class];
    }


    public function toSms($notifiable)
    {
       return [
           "phone" => $this->phone,
           "code" => $this->code,
           "text" => "کاربر گرامی کد ورود شما به اپ $this->code میباشد .",
       ];
    }


}
