<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ScheduledSms extends Model
{
    use HasFactory;

    use Sortable;

    public $sortable = ['sender_id', 'list_id', 'message','def_date','sent','user_id','job_id','due_datetime'];
}
