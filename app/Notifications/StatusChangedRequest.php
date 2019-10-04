<?php

namespace App\Notifications;

use App\Models\Request;
use App\Models\User;
use App\Repositories\TemplateRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\App;

/**
 * Class StatusChangedRequest
 * @package App\Notifications
 */
class StatusChangedRequest extends Notification implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    /**
     * @var int
     */
    public $tries = 3;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Request
     */
    protected $originalRequest;

    /**
     * @var
     */
    protected $originalStatus;

    /**
     * @var User
     */
    protected $user;

    /**
     * StatusChangedRequest constructor.
     * @param Request $request
     * @param Request $originalRequest
     * @param User $user
     */
    public function __construct(Request $request, Request $originalRequest, User $user)
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
        $data = $tRepo->getRequestStatusChangedParsedTemplate($this->request, $this->originalRequest, $this->user);
        $data['userName'] = $notifiable->name;

        $data['lang'] = $notifiable->settings->language ?? App::getLocale();
        return (new MailMessage)
            ->view('mails.request', $data)->subject($data['subject']);
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
            'pinboard_id' => $this->request->id,
            'user_name' => $notifiable->name,
            'fragment' => sprintf('Request: %s status changed to:%',
                $this->request->title,
                $this->request->status
            )
        ];
    }
}
