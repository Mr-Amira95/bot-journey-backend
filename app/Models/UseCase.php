<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UseCase extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];

    public function tags()
    {
        return $this->hasMany(UseCaseTag::class);
    }
}
