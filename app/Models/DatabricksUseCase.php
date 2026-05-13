<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatabricksUseCase extends Model
{
    protected $fillable = [
        'industry',
        'headline',
        'description',
        'order',
    ];

    protected $casts = [
        'industry' => 'array',
        'headline' => 'array',
        'description' => 'array',
    ];
}
