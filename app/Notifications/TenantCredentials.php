<?php

namespace App\Notifications;

use App\Models\RealEstate;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class TenantCredentials
 * @package App\Notifications
 */
class TenantCredentials extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Tenant
     */
    protected $tenant;
    /**
     * @var string
     */
    protected $subject;
    /**
     * @var string
     */
    protected $body;


    /**
     * TenantCredentials constructor.
     * @param Tenant $tenant
     * @param string $subject
     * @param string $body
     */
    public function __construct(Tenant $tenant, string $subject, string $body)
    {
        $this->tenant = $tenant;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $re = RealEstate::firstOrFail();
        $pdfName = $this->tenant->pdfXFileName();
        if ($re && $re->blank_pdf) {
            $pdfName = $this->tenant->pdfFileName();
        }
        $disk = \Storage::disk('tenant_credentials');
        return (new MailMessage)
            ->view('mails.sendTenantCredentials', [
                'body' => $this->body,
                'subject' => $this->subject,
            ])->subject($this->subject);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return $this->toArray($notifiable);
    }
}
