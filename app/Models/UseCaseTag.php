<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UseCaseTag extends Model
{
    protected $fillable = [
        'use_case_id',
        'tag',
    ];

    protected $casts = [
        'tag' => 'array',
    ];

    public function useCase()
    {
        return $this->belongsTo(UseCase::class);
    }
}
