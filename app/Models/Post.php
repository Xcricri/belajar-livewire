<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'image',
        'title',
        'content',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
