<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFeature extends Model
{
    protected $fillable = [
        'project_id',
        'key',
    ];

    protected $casts = [
        'key' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
