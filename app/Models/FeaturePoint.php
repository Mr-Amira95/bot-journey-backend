<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturePoint extends Model
{
    protected $fillable = [
        'feature_id',
        'key',
    ];

    protected $casts = [
        'key' => 'array',
    ];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
