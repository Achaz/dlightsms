<?php

namespace App\Imports;

use App\Models\BcastNumbers;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\DB;


class BcastImport implements ToModel, WithHeadingRow,ShouldQueue, WithChunkReading
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $list_id;
    public $list_name;

    public function __construct($list_id)
    {
        $this->list_id = $list_id;
        $this->data = collect();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //return an eloquent object
        $model = BcastNumbers::firstOrCreate([
            "msisdn" => $row["msisdn"],
            "field1" => $row["name"],
            "field2" => $row["account"],
            "field3" => $row["amount"],
            "field4" => $row["reward"],
            "field5" => $row["token"]

        ]);

       //$sql_exists = BcastNumbers::whereIn("msisdn",$msisdns)->get();
        $sqlb = DB::select("SELECT * FROM bcast_list_maps WHERE num_id =$model->id AND list_id=$this->list_id");
   
        if (isset($sqlb)) {

            DB::table('bcast_list_maps')->insert([
                'num_id' => $model->id,
                'list_id' => $this->list_id
            ]);

        }
        DB::update('UPDATE bcastlists SET last_updated = CURRENT_TIMESTAMP WHERE id = ?', [$this->list_id]);           
    }
    public function chunkSize(): int
    {
        return 20;
    }

    
}
