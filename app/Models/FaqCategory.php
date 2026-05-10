<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'category_id');
    }
}
