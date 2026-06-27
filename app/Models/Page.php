<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'user_id'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
