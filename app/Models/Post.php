<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use SoftDeletes;
    use Searchable;

    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'image',
        'title',
        'content',
        'category_id'
    ];

    /**
     * Summary of dates
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Summary of toSearchableArray
     * @return array{content: string, id: int, title: string}
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'category_id' => $this->category_id
        ];
    }

    /**
     * Summary of category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category, Post>
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
