<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keywords extends Model
{
    use HasFactory;
    protected $table = 'keywords';
    public $timestamps = false;

    protected $fillable = [
        'keywd',
        'keywd_alias',
        'response',
        'created_by',
        'created_at',
    ];
}
