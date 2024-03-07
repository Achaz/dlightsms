<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MO_SMS extends Model
{
    use HasFactory;
    protected $table = 'keywordlogs';
    public $timestamps = false;

    protected $fillable = [
        'sender', 'keywd', 'request','ts_stamp','msgid','dest', 'charset','created','sms_id'
    ];
}
