<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatabricksTrustSignal extends Model
{
    protected $fillable = [
        'text',
        'order',
    ];

    protected $casts = [
        'text' => 'array',
    ];
}
