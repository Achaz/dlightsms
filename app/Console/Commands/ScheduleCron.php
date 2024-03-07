<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

class ScheduleCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     */
    public function handle()
    {
        //\Log::info("Cron is working fine!");

        $sqlq = DB::select("SELECT * FROM scheduled_sms WHERE sent = 0 AND due_datetime <= NOW()");
        \Log::info($sqlq);
        $job_id = '';
        $sender_id = '';
        $message = '';
        $list_id = '';
        $user_id = '';
        $due_datetime = '';
        $def_date = '';
        $sent = '';
        $title = '';
        $network = '';
        $scheduled_id = '';

        if (collect($sqlq)->first()) {

            for ($i=0; $i<=count($sqlq); $i++) {

                try {

                    $job_id = $sqlq[$i]->job_id;
                    $sender_id = $sqlq[$i]->sender_id;
                    $message = $sqlq[$i]->message;
                    $list_id = $sqlq[$i]->list_id;
                    $user_id = $sqlq[$i]->user_id;
                    $due_datetime = $sqlq[$i]->due_datetime;
                    $def_date = $sqlq[$i]->def_date;
                    $sent = $sqlq[$i]->sent;
                    $scheduled_id = $sqlq[$i]->schedule_id;

                    //$sqlq6 = DB::select("UPDATE scheduled_sms SET sent = 1 WHERE job_id = $job_id");

                    DB::table('bcast_queue')->insert([
                        'sender_id' => $sender_id,
                        'msg' => $message,
                        'list_id' => $list_id,
                        'network' => $network,
                        'user_id' => $user_id,
                        'job_id' => $job_id,
                        'title' => $title,
                        'ts_stamp' => \Carbon\Carbon::now()->toDateTimeString(),
                        'sent' => '0',
                        'processing' =>'0'
                    ]);
    
                    DB::update('update scheduled_sms set sent = 1 WHERE schedule_id  = ?',[$scheduled_id]);

                    \Log::info("Messages Scheduled successfully!");

                }catch(\Exception $e) {

                    \Log::error($e->getMessage());

                }
               

            }
           

        } else {
        
            \Log::info("No scheduled messages");
        }

    }
}
