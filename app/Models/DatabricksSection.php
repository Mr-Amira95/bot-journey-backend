<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatabricksSection extends Model
{
    protected $fillable = [
        'section_key',
        'title',
        'subtitle',
        'extra_data',
    ];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'extra_data' => 'array',
    ];
}
