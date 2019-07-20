<?php

namespace App\Notifications;

use App\Models\ServiceRequest;
use App\Models\RealEstate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTenantRequest extends Notification implements ShouldQueue
{
    use Queueable;

    protected $serviceRequest;
    protected $subject;
    protected $body;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ServiceRequest $serviceRequest, string $subject, string $body)
    {
        $this->serviceRequest = $serviceRequest;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $rl = RealEstate::firstOrFail();
        return (new MailMessage)
            ->view('mails.pinnedPostPublished', [
                'body' => $this->body,
                'subject' => $this->subject,
                'userName' => $notifiable->name,
                'companyName' => $rl->name,
            ])->subject($this->subject);
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return $this->toArray($notifiable);
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
            'post_id' => $this->serviceRequest->id,
            'user_name' => $this->serviceRequest->tenant->user->name,
            'fragment' => 'New request opened',
        ];
    }
}
