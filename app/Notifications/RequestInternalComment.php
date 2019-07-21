<?php

namespace App\Notifications;

use App\Models\ServiceRequest;
use App\Models\RealEstate;
use App\Models\User;
use App\Repositories\TemplateRepository;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class RequestInternalComment extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sr;
    protected $comment;
    protected $receiver;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ServiceRequest $sr, Comment $comment, User $receiver)
    {
        $this->sr = $sr;
        $this->comment = $comment;
        $this->receiver = $receiver;
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
        $rl = RealEstate::firstOrFail();
        $tRepo = new TemplateRepository(app());
        $msg = $tRepo->getRequestInternalCommentParsedTemplate($this->sr, $this->comment, $this->comment->user, $this->receiver);
        return (new MailMessage)
            ->view('mails.requestInternalComment', [
                'body' => $msg['body'],
                'subject' => $msg['subject'],
                'userName' => $notifiable->name,
                'companyName' => $rl->name,
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
            'request_id' => $this->sr->id,
            'comment' => $this->comment->comment,
            'sender' => $this->comment->user->name,
            'receiver' => $this->receiver->name,
        ];
    }

    public function toDatabase($notifiable)
    {
        return $this->toArray($notifiable);
    }
}
