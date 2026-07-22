<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
    /**
     * لیست مدل به همراه تگی که به آن اختصاص داده شده است
     */
    public $timestamps = false;
    protected $table = 'taggables';
    protected $fillable = ['tag_id', 'taggable_type', 'taggable_id'];
}
