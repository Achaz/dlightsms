<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\BcastNumbers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class BcastNumbersCSVJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $header;
    public $data;
    public $list_id;
  
    /**
     * Create a new job instance.
     */
    public function __construct($data,$header, $list_id)
    {
        $this->data = $data;
        $this->header = $header;
        $this->list_id = $list_id;      
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //dd($this->data);
        $list_id = $this->list_id;
    
        foreach ($this->data as $bcastbumbers) {

            $numb = $bcastbumbers;

            $msisdn = array_shift($numb);
        
            $bcastnumber_csv_data = array_combine($this->header,$bcastbumbers);
            
            BcastNumbers::create($bcastnumber_csv_data);

            $sql_exists = DB::select("SELECT * FROM bcast_numbers WHERE msisdn = $msisdn");

            //dd($sql_exists);
            $num_id = $sql_exists[0]->id;

            $sqlb = DB::select("SELECT * FROM bcast_list_maps WHERE num_id =$num_id AND list_id=$this->list_id");

            if (isset($sqlb)) {

                DB::table('bcast_list_maps')->insert([
                    'num_id' => $num_id,
                    'list_id' => $this->list_id
                ]);

            }
            
        }
        
    }

}
