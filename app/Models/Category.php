<?php

namespace App\Models;

use App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Category extends Model
{
    use Searchable;

    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * Summary of toSearchableArray
     * @return array{content: string, id: int, title: string}
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    /**
     * Summary of posts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Post, Category>
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
