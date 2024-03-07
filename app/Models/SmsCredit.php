<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsCredit extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    // public function Staff()
    // {
    //     return $this->belongsTo(Staff::class,'user_id','staff_id');
    // }

    public function User()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
