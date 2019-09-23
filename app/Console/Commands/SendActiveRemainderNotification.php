<?php

namespace App\Console\Commands;

use App\Models\RentContract;
use App\Models\ServiceRequest;
use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendActiveRemainderNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-active-remainder-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make rent contract inactive after expiration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $serviceRequests = ServiceRequest::where('due_date', '>=', now()->format('Y-m-d'))
            ->where('is_sent_remainder_notification', 0) // @TODO need use class constant or not
            ->where('active_reminder', 1) // @TODO need use class constant or not
            ->with('remainder_user')
            ->whereColumn('days_left_due_date', '=', DB::raw('DATEDIFF(due_date, CURDATE())'))
            ->get(['id', 'reminder_user_id']);

        foreach ($serviceRequests as $serviceRequest) {
            if ($serviceRequest->remainder_user) {
                $serviceRequest->remainder_user->notify(new \App\Notifications\SendActiveRemainderNotification($serviceRequest));
            }
            $serviceRequest->is_sent_remainder_notification = 1;
            $serviceRequest->save();
        }
    }
}
