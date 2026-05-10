<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'title',
        'stat_value',
        'stat_suffix',
        'stat_description',
    ];

    protected $casts = [
        'title' => 'array',
        'stat_suffix' => 'array',
        'stat_description' => 'array',
    ];

    public function points()
    {
        return $this->hasMany(FeaturePoint::class);
    }
}
