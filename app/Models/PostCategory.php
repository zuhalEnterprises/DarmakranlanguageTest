<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    /**
     * دسته بندیهای اختصاص داده شده به پست ها
     *
     * @return string
     */
    protected $table = 'post_category';
    protected $fillable = [
        'post_id',
        'category_id',
    ];

    /**
     * دسته بندی اختصاص داده شده
     *
     * @return object
     */
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    /**
     * پستی که دسته بندی به آن اختصاص داده شده
     *
     * @return object
     */
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id');
    }
}
