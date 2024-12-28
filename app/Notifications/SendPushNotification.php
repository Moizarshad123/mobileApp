<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;
use Illuminate\Support\Facades\Log;
class SendPushNotification extends Notification
{
    use Queueable;
  
    protected $title;
    protected $message;
    protected $fcmTokens;

    public function __construct($title, $message, $fcmTokens)
    {
        $this->title          = $title;
        $this->message        = $message;
        $this->fcmTokens      = $fcmTokens;
    }

    public function via($notifiable)
    {
        return ['firebase'];
    }

    public function toFirebase($notifiable)
    {
        try{

            $response =   (new FirebaseMessage)
                        ->withTitle($this->title)
                        ->withBody($this->message)
                        ->withSound('default')
                        ->withPriority('high')
                        ->asNotification($this->fcmTokens);
            Log::debug('side hustle notification response', array('response' => $response));
            return $response;
        } catch (\Exception $ex) {
            echo $ex->getMessage();exit;
        }
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

}
