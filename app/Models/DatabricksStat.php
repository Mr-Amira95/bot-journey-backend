<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatabricksStat extends Model
{
    protected $fillable = [
        'value',
        'label',
        'color',
        'order',
    ];

    protected $casts = [
        'label' => 'array',
    ];
}
