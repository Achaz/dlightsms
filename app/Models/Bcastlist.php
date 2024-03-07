<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bcastlist extends Model
{
    use HasFactory;

    protected $table = 'bcastlists';

    public $timestamps = false;

    protected $fillable = ['name', 'description', 'created_by'];

    // public function Staff()
    // {
    //     return $this->belongsTo(Staff::class,'created_by','staff_id');
    // }

    public function User()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function Billlogs()
    {
        return $this->hasMany(Bill_log::class,'list_id','id');
    }

}
