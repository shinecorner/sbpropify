<?php

namespace App\Notifications;

use App\Models\RealEstate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class NewAdmin
 * @package App\Notifications
 */
class NewAdmin extends Notification implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    public $tries = 3;

    /**
     * @var string
     */
    protected $subject;
    /**
     * @var string
     */
    protected $body;
    /**
     * @var string
     */
    protected $logo;

    /**
     * PasswordResetRequest constructor.
     * @param string $subject
     * @param string $body
     * @param RealEstate $settings
     */
    public function __construct(string $subject, string $body, RealEstate $settings)
    {
        $this->subject = $subject;
        $this->body = $body;
        $logo = $settings->logo ?? 'images/logo3.png';
        $this->logo = env('APP_URL', 'http://localhost') . '/' . $logo;
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
        $rl = RealEstate::firstOrFail();
        $data = [
            'body' => $this->body,
            'logo' => $this->logo,
            'userName' => $notifiable->name,
            'companyName' => $rl->name,
        ];

        return (new MailMessage)
            ->view('mails.users.userPasswordReset', $data)
            ->subject($this->subject);
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
