<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'type',
        'title',
        'subtitle',
        'badge',
        'button_text',
        'button_direction',
    ];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'badge' => 'array',
        'button_text' => 'array',
    ];
}
