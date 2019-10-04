<?php

namespace App\Notifications;

use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class NewAdmin
 * @package App\Notifications
 */
class SendActiveRemainderNotification extends Notification implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    public $tries = 3;

    /**
     * @var Request
     */
    protected $request;

    /**
     * SendActiveRemainderNotification constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $data = ['user' => $notifiable, 'request' => $this->request];
        $data['subject'] = 'SendActiveRemainderNotification';
        return (new MailMessage)
            ->view('mails.sendActiveRemainderNotification', $data)
            ->subject($data['subject']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
