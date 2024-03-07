<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    public function getTypeStringAttribute()
    {
        switch ($this->isadmin) {
            case 1:
                return "Admin";
                break;
            case 0:
                return "Customer Care";
                break;
            case 2:
                return "API Account";
                break;
            
        }
    }

    public function getStatusStringAttribute()
    {
        switch ($this->isadmin) {
            case 1:
                return "Admin";
                break;
            case 2:
                return "CC Manager";
                break;
            case 3:
                return "CC Supervisor";
                break;
            case 4:
                return "Agent";
                break;
            case 5:
                return "API User";
                break;
        }
    }

    public function lists()
    {
        return $this->hasMany(Bcastlist::class);
    }

    public function smsroutes(): HasMany 
    {
        return $this->hasMany(SmsRoutes::class);
    }

    public function credits()
    {
        return $this->hasMany(SmsCredit::class,'user_id','staff_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class,'user_id','staff_id');
    }

    public function credithistories()
    {
        return $this->hasMany(SmsCreditHistory::class,'user_id','staff_id');
    }

    public function billlogs()
    {
        return $this->hasMany(Bill_log::class,'user_id','staff_id');
    }


}
