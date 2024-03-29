<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsCreditHistory extends Model
{
    use HasFactory;

    // public function Staff()
    // {
    //     return $this->belongsTo(Staff::class,'user_id','staff_id');
    // }

    public function User()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
