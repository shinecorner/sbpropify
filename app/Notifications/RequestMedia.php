<?php

namespace App\Notifications;

use App\Models\ServiceRequest;
use App\Models\RealEstate;
use App\Models\User;
use App\Repositories\TemplateRepository;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class RequestMedia extends Notification implements ShouldQueue
{
    use Queueable;

    protected $request;
    protected $uploader;
    protected $media;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ServiceRequest $request, User $uploader, Media $media)
    {
        $this->request = $request;
        $this->uploader = $uploader;
        $this->media = $media;
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
        $msg = $tRepo->getRequestMediaParsedTemplate($this->request, $this->uploader, $notifiable, $this->media);
        return (new MailMessage)
            ->view('mails.requestMedia', [
                'body' => $msg['body'],
                'subject' => $msg['subject'],
                'userName' => $notifiable->name,
                'companyName' => $rl->name,
            ])->subject($msg['subject'])
            ->attach($msg['media']->getPath());
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
            'uploader' => $this->uploader,
            'media' => $this->media,
            'fragment' => Str::limit($this->request->title, 128),
        ];
    }

    public function toDatabase($notifiable)
    {
        return $this->toArray($notifiable);
    }
}
