<?php

namespace App\Notifications;

use App\Models\Product;
use App\Models\RealEstate;
use App\Models\Tenant;
use App\Repositories\TemplateRepository;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class ProductCommented extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;
    protected $commenter;
    protected $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Product $product, Tenant $commenter, Comment $comment)
    {
        $this->product = $product;
        $this->commenter = $commenter;
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
        if ($notifiable->settings && $notifiable->settings->marketplace_notification) {
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
        $msg = $tRepo->getProductCommentedParsedTemplate($this->product, $this->commenter->user, $this->comment);
        return (new MailMessage)
            ->view('mails.productCommented', [
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
            'product_id' => $this->product->id,
            'tenant' => $this->commenter->name,
            'comment' => $this->comment->comment,
            'fragment' => Str::limit($this->product->title, 128),
        ];
    }

    public function toDatabase($notifiable)
    {
        return $this->toArray($notifiable);
    }
}
