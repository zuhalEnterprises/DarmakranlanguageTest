<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;


class Image extends Model
{
    /**
     * تصاویر ملک
     *
     * @return string
     */
    protected $table = 'images';

    /**
     * فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = ['is_360','estate_id','user_id', 'name', 'token', 'extension', 'url', 'dimension', 'cover','month' , 'year','plan' , 'priority'];

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
    public function estate()
    {
        return $this->belongsTo(Estate::class, 'estate_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function url()
    {

        if($this->year != '' && $this->month != '')
        {
            return $this->year.'/'.$this->month.'/'.$this->url;
        }
        else
        {

            return $this->url;
        }
    }
    public function path()
    {
        if($this->year != '' && $this->month != '')
        {
            $path = $this->year.'/'.$this->month.'/'.$this->url;
        }
        else
        {
            $path = $this->url;
        }
        return base_path() . '/upload/images/estate/' . $path;
    }
}
