<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsRoutes extends Model
{
    use HasFactory;

    // public function Staff(): BelongsTo
    // {
    //     return $this->belongsTo(Staff::class);
    // }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
