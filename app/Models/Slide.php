<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Slide extends BaseModel
{
    use HasRoles;
    protected $guard_name = 'web';

    /**
     * تصاویر اسلایدشوها
     *
     * @return string
     */
    protected $table = 'slides';
    protected $fillable = [
        'template_page_id',
        'show_place',
        'image',
        'image_tablet',
        'image_mobile',
        'title',
        'description',
        'url',
        'position',
        'active'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * آدرس نهایی تصویر اسلایدشو : سایز اصلی
     *
     * @return string
     */
    public function image()
    {
        $img = !empty($this->image) ? 'slides/' . $this->image : $this->image;
        return getImage($img);
    }

    /**
     * آدرس نهایی تصویر اسلایدشو : سایز تبلت
     *
     * @return string
     */
    public function imageTablet()
    {
        $img = !empty($this->image_tablet) ? 'slides/' . $this->image_tablet : $this->image_tablet;
        return getImage($img);
    }

    /**
     * آدرس نهایی تصویر اسلایدشو :  سایز گوشی
     *
     * @return string
     */
    public function imageMobile()
    {
        $img = !empty($this->image_mobile) ? 'slides/' . $this->image_mobile : $this->image_mobile;
        return getImage($img);
    }

    /**
     * صفحه ای از قالب که نیاز به نمایش اسلایدشو دارید
     *
     * @return object
     */
    public function templatePage()
    {
        return $this->belongsTo(TemplatePage::class, 'template_page_id');
    }
}
