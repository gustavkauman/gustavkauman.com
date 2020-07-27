<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    // Make all attributes mass assignable
    protected $guarded = [];

    /**
     * Get the author of the post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
