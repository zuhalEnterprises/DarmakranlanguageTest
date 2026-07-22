<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * جایگزین کردن namespace کلاس مدل با نام مدل
 */
Relation::morphMap([
    'post' => 'App\Model\Post',
]);

class Tag extends Model
{
    /**
     * تگ های پست های بلاگ
     *
     * در این جدول از رابطه پلی‌مورفیک چند به چند استفاده شده است
     *
     * @return string
     */
    protected $table = 'tags';
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at'];

    /**
     * لیست پست هایی که این تگ به آنها اختصاص داده شده اند
     */
    public function posts()
    {
        return $this->morphedByMany('App\Model\Post', 'taggable');
    }
    /**
     * لیست خانه هایی که این تگ به آنها اختصاص داده شده اند
     */
    public function estates()
    {
        return $this->morphedByMany('App\Model\Estate', 'taggable');
    }
}
