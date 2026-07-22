<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class TemplatePage extends Model
{
    use HasRoles;
    protected $guard_name = 'web';

    /**
     * صفحات قالب : این صفحات از طریق مدیریت در قسمت تنظیمات صفحات قالب در دسترس است
     *
     * @return string
     */
    protected $table = 'template_pages';
    public $fillable=['page_id','name','title','description','url'];

    /**
     * تبلیغاتی که در صفحه قالب موردنظر وجود دارند
     *
     * @return object
     */
    public function ads()
    {
        return $this->hasMany(Ads::class,'template_page_id');
    }
}
