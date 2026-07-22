<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends BaseModel
{
    protected $table = 'sessions';
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
