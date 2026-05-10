<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'category_id',
        'question',
        'answer',
        'featured',
        'media',
    ];

    protected $casts = [
        'question' => 'array',
        'answer' => 'array',
        'featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'category_id');
    }
}
