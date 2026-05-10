<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndustryMedia extends Model
{
    protected $fillable = [
        'industry_id',
        'media_path',
    ];

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}
