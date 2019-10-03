<?php

namespace App\Console\Commands;

use App\Models\Request;
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
    protected $description = 'send active remainder notification';

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

        $requests = Request::where('due_date', '>=', now()->format('Y-m-d'))
            ->where('active_reminder', 1) // @TODO need use class constant or not
            ->with('remainder_user')
            ->whereRaw("sent_reminder_user_ids not like CONCAT('%', reminder_user_id, '%') ") // each user send only one time
            ->whereColumn('days_left_due_date', '=', DB::raw('DATEDIFF(due_date, CURDATE())'))
            ->get(['id', 'reminder_user_id', 'sent_reminder_user_ids']);

        foreach ($requests as $request) {
            if ($request->remainder_user) {
                $request->remainder_user->notify(new \App\Notifications\SendActiveRemainderNotification($request));
                $sentReminderUserIds = $request->sent_reminder_user_ids ?? [];
                $sentReminderUserIds[] = $request->remainder_user->id; // diff user send email when each day update service request
                $request->sent_reminder_user_ids = $sentReminderUserIds;
                $request->save();
            } else {
                $request->reminder_user_id = null; // when user is deleted or wrong id
                $request->save();
            }
        }
    }
}
