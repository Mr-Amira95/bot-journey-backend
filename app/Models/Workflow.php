<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'order',
        'icon',
    ];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
    ];
}
