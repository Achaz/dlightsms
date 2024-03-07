<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\BcastNumbers;

class QueuedImport implements ToModel, WithHeadingRow,ShouldQueue, WithChunkReading 
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BcastNumbers([
            "msisdn" => $row["msisdn"],
            "field1" => $row["name"],
            "field2" => $row["account"],
            "field3" => $row["amount"],
            "field4" => $row["reward"],
            "field5" => $row["token"],
            "field6" => $row["days"]           
        ]);
    }

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function chunkSize(): int
    {
        return 20;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
    }
}
