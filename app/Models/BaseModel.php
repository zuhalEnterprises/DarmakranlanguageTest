<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BaseModel extends Model
{
    

    /**
     * برای ثبت لاگ روی مدلها از trait LogsActivity در پکیج Spatie\Activitylog استفاده میکنیم ، اینجا برای راحتی کار یک مدل ساختیم که مدلهای دیگر ارث بری کنند تا نیاز به بازنویسی در همه مدل ها نباشد
     */
    use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    public function getLogNameToUse(): string
    {
        return basename(get_class($this));
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }
    /**
     *  برای جستجو در لیست های مدیریت و همچنین جهت تمیز بودن کد از این متد کمکی و همچنین پکیج Spatie\QueryBuilder استفاده شده است
     * البته بعضی از لیست ها بصورت دستی کنترل میشود ، برای نمونه جستجو در لیست املاک در مدیریت ، استفاده از پکیج برای شرایط خاص میسر نبود
     *
     * @param array $inputs فیلدهای کلاس مدل موردنظر
     * @param null $inputsAppends فیلدهای اضافه اختیاری برای جستجو در لیست
     * @param bool $filterKey برای زمانی که از پکیج استفاده نمیشود false قرار دهید، مثال: متد index در EstateController
     * @return array
     */
    public function getFilters($inputs,$inputsAppends=null,$filterKey=true)
    {
        $filters = [];
        $fields = array_merge(['id','created_at'], $this->getFillable());
        foreach ($fields as $field){
            $mainField = $field;
            $field = $filterKey ? "filter[$field]" : $field;

            $filters[$field] = $inputs[$mainField] ?? '';
        }

        if(!empty($inputsAppends)){
            foreach ($inputsAppends as $field){
                $field = $filterKey ? "filter[$field]" : $field;
                $filters[$field] = $inputsAppends[$field] ?? '';
            }
        }

        // اشتراک گذاری آرایه نهایی در سمت ویو بخش مدیریت: بطور مثال در لیست اعضای سیستم فیلترهای اعمال شده در فرم جستجوی بالای صفحه قابل دستیابی است
        View::share('filters', $filters);

        return $filters;
    }
}
