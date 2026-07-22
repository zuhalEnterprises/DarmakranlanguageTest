<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;


class Picture extends Model
{
    /**
     * تصاویر ملک
     *
     * @return string
     */
    protected $table = 'picture';

    /**
     * فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = ['category_id','pic_format', 'convert'];

    /**
     * فیلدهایی که باید مخفی شوند
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     *  فیلدهایی که به تاریخ تبدیل میشوند
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * فیلدهایی که باید به یک نوع دیگر تبدیل شوند
     *
     * @var array
     */

}
