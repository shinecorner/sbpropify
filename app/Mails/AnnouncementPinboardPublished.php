<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Pinboard;

class AnnouncementPinboardPublished extends Mailable
{
    use Queueable, SerializesModels;

    public $pinboard;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pinboard $pinboard)
    {
        $this->pinboard = $pinboard;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.announcementPinboardPublished')
            ->subject($this->pinboard->title)
            ->with([
                'pinboard' => $this->pinboard,
            ]);
    }
}
