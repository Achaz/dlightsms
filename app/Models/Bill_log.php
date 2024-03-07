<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill_log extends Model
{
    use HasFactory;
    public $timestamps =false;

    protected $table = 'bill_logs';

    // public function Staff()
    // {
    //     return $this->belongsTo(Staff::class,'user_id','staff_id');
    // }

    public function User()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function lists()
    {
        return $this->belongsTo(Bcastlist::class,'list_id','id');
    }

}
