<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class BcastNumbers extends Model
{
    use HasFactory;

    use Sortable;
    
    public $timestamps = false;

    protected $table = 'bcast_numbers';

    protected $fillable = [
        'msisdn', 'field1', 'field2','field3','field4','field5', 'field6'
    ];

    public $sortable = ['msisdn', 'field1', 'field2','field3','field4','field5','field6'];
}
