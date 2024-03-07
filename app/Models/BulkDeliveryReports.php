<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkDeliveryReports extends Model
{
    use HasFactory;

    protected $table = 'ost_dlr_reports';

    public $timestamps = false;

    public function getStatusStringAttribute()
    {
        switch ($this->dlrvalue) {

            case 1:
                return "DELIVRD";
                break;
            case 2:
                return "NOT-DELIVRD TO PHONE";
                break;
            case 4:
                return "QUEUED ON SMSC";
                break;           
            case 8:
                return "SENT TO SMSC";
                break;
            case 16:
                return "NON-DELIVRD TO SMSC";
                break;
            case 34:
                return "EXPIRED";
                break;
                    
        }


    }


}
