<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\ServiceProvider;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\App;

class NotifyServiceProvider extends Mailable
{
    use Queueable, SerializesModels;

    private $provider;
    private $request;
    private $mailDetails;
    private $receivingUser;

    /**
     * NotifyServiceProvider constructor.
     * @param ServiceProvider $serviceProvider
     * @param Request $request
     * @param array $mailDetails
     * @param null $user
     */
    public function __construct(
        ServiceProvider $serviceProvider,
        Request $request,
        array $mailDetails, $user = null)
    {
        $this->provider = $serviceProvider;
        $this->request = $request;
        $this->mailDetails = $mailDetails;
        $this->receivingUser = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        if ($this->receivingUser) {
//            $this->receivingUser->redirect = "/admin/requests/" . $this->request->id;
//        }
        return $this->view('mails.notifyServiceProvider')
            ->subject($this->mailDetails['title'] ?? "")
            ->with([
                'provider' => $this->provider,
                'details' => $this->mailDetails,
                'user' => $this->receivingUser,
                'lang' => $this->provider->settings->language ?? App::getLocale()
            ]);
    }
}
