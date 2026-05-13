<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiSubpoint extends Model
{
    protected $fillable = [
        'icon',
        'title',
        'description',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];}
