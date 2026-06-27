<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Page extends Model
{
    use SoftDeletes;
    use Searchable;

    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'user_id'
    ];

    /**
     * Summary of dates
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

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
        ];
    }


    /**
     * Summary of users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Page>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
