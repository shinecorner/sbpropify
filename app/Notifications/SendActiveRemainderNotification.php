<?php

namespace App\Notifications;

use App\Models\ServiceRequest;
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
     * @var ServiceRequest
     */
    protected $serviceRequest;

    /**
     * SendActiveRemainderNotification constructor.
     * @param ServiceRequest $serviceRequest
     */
    public function __construct(ServiceRequest $serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
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
        $data = ['user' => $notifiable, 'serviceRequest' => $this->serviceRequest];
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
