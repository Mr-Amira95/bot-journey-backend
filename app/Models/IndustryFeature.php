<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndustryFeature extends Model
{
    protected $fillable = [
        'industry_id',
        'key',
    ];

    protected $casts = [
        'key' => 'array',
    ];

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}
