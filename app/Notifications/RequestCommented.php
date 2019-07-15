<?php

namespace App\Notifications;

use App\Models\ServiceRequest;
use App\Models\User;
use App\Repositories\TemplateRepository;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class RequestCommented extends Notification implements ShouldQueue
{
    use Queueable;

    protected $request;
    protected $user;
    protected $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ServiceRequest $request, User $user, Comment $comment)
    {
        $this->request = $request;
        $this->user = $user;
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->settings && $notifiable->settings->service_notification) {
            return ['database', 'mail'];
        }

        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $tRepo = new TemplateRepository(app());
        $msg = $tRepo->getRequestCommentedParsedTemplate($this->request, $this->user, $this->comment);
        return (new MailMessage)
            ->view('mails.requestCommented', [
                'body' => $msg['body'],
                'subject' => $msg['subject'],
            ])->subject($msg['subject']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'request_id' => $this->request->id,
            'user' => $this->comment->user->name,
            'comment' => $this->comment->comment,
            'fragment' => Str::limit($this->request->title, 128),
        ];
    }

    public function toDatabase($notifiable)
    {
        return $this->toArray($notifiable);
    }
}
