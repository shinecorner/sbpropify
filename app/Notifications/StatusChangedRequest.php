<?php

namespace App\Notifications;

use App\Models\ServiceRequest;
use App\Models\User;
use App\Repositories\TemplateRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Class StatusChangedRequest
 * @package App\Notifications
 */
class StatusChangedRequest extends Notification implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    public $tries = 3;

    protected $request;
    protected $originalRequest;
    protected $originalStatus;
    protected $user;

    /**
     * StatusChangedRequest constructor.
     * @param ServiceRequest $request
     * @param ServiceRequest $originalRequest
     * @param User $user
     */
    public function __construct(ServiceRequest $request, ServiceRequest $originalRequest, User $user)
    {
        $this->request = $request;
        $this->user = $user;
        $this->originalRequest = $originalRequest;
        $this->originalStatus = $originalRequest->status;
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
        $this->originalRequest->status = $this->originalStatus;

        $tRepo = new TemplateRepository(app());
        $msg = $tRepo->getRequestStatusChangedParsedTemplate($this->request, $this->originalRequest, $this->user);

        return (new MailMessage)
            ->view('mails.request', [
                'body' => $msg['body'],
                'subject' => $msg['subject'],
            ])->subject($msg['subject']);
    }

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
            'user_name' => 'test',
            'fragment' => sprintf('Request: %s status changed to:%',
                $this->request->title,
                $this->request->status
            )
        ];
    }
}
