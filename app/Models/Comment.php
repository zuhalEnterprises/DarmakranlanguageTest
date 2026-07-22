<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $fillable = [
        'commentable_type', 'commentable_id', 'parent_id', 'user_id',
        'name', 'email', 'body', 'rate', 'status' , 'lang'
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function statusname()
    {
        switch($this->status)
        {
            case 'pending':
                return l('در حال بررسی');
            case 'verified':
                return l('تایید شده');
            case 'rejected':
                return l('رد شده');
        }
    }
}
