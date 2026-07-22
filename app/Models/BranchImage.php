<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;


class BranchImage extends Model
{
    /**
     * تصاویر ملک
     *
     * @return string
     */
    protected $table = 'branch_images';

    /**
     * فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = ['branch_id','user_id', 'name', 'token', 'extension', 'url', 'dimension', 'cover','is_360','month' , 'year'];

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
    protected $casts = ['dimension' => 'array'];

    /**
     * ملکی که تصویر موردنظر به آن تعلق دارد
     *
     * @return object
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function url()
    {
        return $this->url;
    }
}
