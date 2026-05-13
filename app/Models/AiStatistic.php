<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiStatistic extends Model
{
    protected $fillable = [
        'value',
        'label',
    ];

    protected $casts = [
        'label' => 'array',
    ];}
