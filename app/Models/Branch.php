<?php

namespace App\Models;

class Branch extends BaseModel
{
    /**
     *  شعبه ها
     *
     * @var string
     */
    protected $table = 'branches';

    /**
     * لیست فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = [
        # شناسه استان
        'province_id',
        # شناسه شهر
        'city_id',
        # شناسه محله
        'district_id',

         # نوع بنگاه: 1=دپارتمان 2=مغازه
         'type',
         # نام فایل تصویری لوگو
        'logo',
        'name',
        # تلفن دفتر
        'phone',
        # آدرس
        'address',

        # عرض جغرافیایی
        'latitude',
        # طول جغرافیایی
        'longitude',
        # توضیحات
        'description',
        # ساعات کاری (جیسون): ساعت شروع و ساعت پایان
        'working_hours',
        # تعداد اتاق قرارداد
        'contract_room_count',
        # لیست مدیران قرارداد بصورت جیسون
        'contract_coordinators',
        # میزان آشنایی با قرارداد نویسی: 1=خیلی زیاد 2=زیاد 3=متوسط 4=ضعیف 5=خیلی ضعیف
        'contract_writing_level',

        #محل
        'location',

        # وضعیت تایید: 0=در انتظار تایید 1=تایید شده
        'status',
        # وضعیت فعال جهت نمایش: 0=غیرفعال 1=فعال
        'active',
        #اطلاعات متنی شعبه
        'comment'
    ];

    /**
     * فیلدهایی که باید به تاریخ تبدیل شوند
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * فیلدهایی که در زمان نمایش باید مخفی باشند
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];





    /**
     *  پیام ها : این مورد زمان تایید یا عدم تایید شعبه به کار میرود، به این صورت که زمان تغییر وضعیت با توجه به نیاز پیام مربوطه باید درج شود
     *
     * توجه داشته باشید که مدل پیام بصورت عمومی نوشته شده است بطوری که میتوان در بخشهای مختلف از آن استفاده کرد
     *
     * @return object
     */
    public function messages()
    {
        return $this->morphMany('App\Model\Message', 'model');
    }




    /**
     *  تصاویر کاور
     *
     * در صورتی که هر یک از تصاویر کاور وجود داشته باشد لینک تصویر نهایی را برمیگرداند
     *
     * @return string
     */
    /**
     * تصاویر شعبه
     *
     * @return object
     */
    public function images()
    {
        return $this->hasMany(BranchImage::class, 'branch_id');
    }
    public function coverImage()
    {
        $firstImage = $this->images->where('hidden','!=',1)->where('plan','!=',1)->where('is_360','!=',1)->where('cover',1)->first();
        if($firstImage == null)
        {
            $firstImage = $this->images->where('hidden','!=',1)->where('plan','!=',1)->where('is_360','!=',1)->first();
        }


        $coverImage = $firstImage && is_array($firstImage->dimension) && isset($firstImage->dimension['large']) ? asset(getDomainImg($firstImage->id).'/upload/images/branch/'.$firstImage->dimension['large']): '';
        return $coverImage;
    }

    /**
     * محل های فعالیت کارشناس
     *
     * @return object
     */
    public function districts()
    {
        return $this->belongsToMany(District::class, 'branch_districts', 'branch_id', 'district_id')->withPivot('selection_count', 'ratio')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
