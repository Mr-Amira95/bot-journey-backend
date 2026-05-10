<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $fillable = [
        'title',
        'description',
        'tagline',
        'color',
        'icon_path',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'tagline' => 'array',
    ];

    public function features()
    {
        return $this->hasMany(IndustryFeature::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function media()
    {
        return $this->hasMany(IndustryMedia::class);
    }
}
