<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];
}
