<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'industry_id',
        'title',
        'description',
        'outcome_value',
        'outcome_label',
        'color',
        'icon_path',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'outcome_label' => 'array',
    ];

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function features()
    {
        return $this->hasMany(ProjectFeature::class);
    }

    public function media()
    {
        return $this->hasMany(ProjectMedia::class);
    }
}
