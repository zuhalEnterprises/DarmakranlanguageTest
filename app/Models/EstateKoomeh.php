<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class EstateKoomeh extends BaseModel
{
    use SoftDeletes, HasRoles;
    protected $guard_name = 'web';

    /**
     * ملک ها
     *
     * @return string
     */
    protected $table = 'estates_koomeh';

    /**
     * فیلدهای قابل پذیرش برای ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'expert_id',
        'shownexpert_id',
        'province_id',
        'city_id',
        'district_id',
        'street_id',
        'token',
        'type',
        'request_type',
        'estate_type',
        'owner_gender',
        'owner_name',
        'phone',
        'phone2',
        'acquaintance_type',
        'sale_reason',
        'sale_priority',
        'residence_type',
        'commission',
        'commission_type',
        'commission_amount',
        'commission_percent',
        'area',
        'built_area',
        'keynot',
        'front_area',
        'street_width',
        'floor_area',
        'price',
        'price_per_meter',
        'loan',
        'monthly_installments',
        'paid_installments',
        'mortgage',
        'rent',
        'rent_type',
        'room_count',
        'floor_count',
        'floor_start',
        'floor',
        'unit_in_floor',
        'built_year',
        'floor_type',
        'position_type',
        'geography',
        'usage_type',
        'structure_type',
        'document_type',
        'facilities',
        'kitchen',
        'heating_cooling',
        'conditions',
        'wc',
        'build_license',
        'convertible',
        'address',
        'unit_no',
        'image_count',
        'image_cover',
        'video',
        'audio',
        'latitude',
        'longitude',
        'latitude_secondary',
        'longitude_secondary',
        'title',
        'description',
        'private_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'link_rewrite',
        'visit',
        'enable_chat',
        'enable_phone',
        'accord',
        'exchange',
        'exchange_comment',
        'special',
        'urgent',
        'visibility',
        'archive_by_user',
        'label',
        'build_density',
        'platform',
        'confirmation',
        'vrhouse',
        'comment',
        'percent_commission',
        'sound',
        'active',
        'status',
        'divar',
        'buildingname',
        'evacuation',
        'evacuationdate',
        'onebuilding',
        'SeparateVilla',
        'balconmetraj',
        'undermetraj',
        'shopheight',
        'restaurant',
        'published_at',
        'expired_at',
        'showdate',
        'expiretime_expert',
        'percent_expert',
        'max_person'
    ];

    /**
     * فیلدهایی که باید به تاریخ تبدیل شوند
     *
     * @return object
     */

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * کاربر ثبت کننده ملک
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * کارشناس ثبت کننده ملک
     *
     * @return object
     */
    public function expert()
    {
        return $this->belongsTo(User::class, 'expert_id');
    }
    /*public function shownexpert()
    {
        return $this->belongsTo(User::class, 'shownexpert_id');
    }*/

    /**
     * کارشناس ثبت کننده ملک
     *
     * @return object
     */
    public function agent()
    {
        return $this->expert();
    }

    /**
     * استانی که ملک در آن ثبت شده است
     *
     * @return object
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    /**
     * شهری که ملک در آن ثبت شده است
     *
     * @return object
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * محله ای که ملک در آن ثبت شده است
     *
     * @return object
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    public function street()
    {
        return $this->belongsTo(Street::class, 'street_id');
    }

    /**
     * لیست یورزهایی که این ملک در لیست علاقه مندی ها وجود دارد
     *
     * @return object
     */
    public function favorites()
    {
        return $this->belongsToMany(User::class,'estate_favorites','estate_id','user_id')->withPivot('pin')->withTimestamps();
    }

    /**
     * لیست یورزهایی که این ملک در لیست مقایسه ها وجود دارد
     *
     * @return object
     */
    public function compare()
    {
        return $this->belongsToMany(User::class,'estate_compare','estate_id','user_id')->withPivot('pin')->withTimestamps();
    }

    /**
     * تصاویر ملک
     *
     * @return object
     */
    public function images()
    {
        return $this->hasMany(Image::class, 'estate_id');
    }

    /**
     * گفتگوهایی که در رابطه با ملک وجود دارد
     *
     * @return object
     */
    public function chats()
    {
        return $this->hasMany(Chat::class, 'estate_id');
    }

    /**
     * یادداشت هایی که در رابطه با این ملک توسط کاربران ثبت شده است
     *
     * @return object
     */
    public function notes()
    {
        return $this->hasMany(EstateNote::class, 'estate_id');
    }

    /**
     * گزارش های مشکل در رابطه با ملک موردنظر
     *
     * @return object
     */
    public function reports()
    {
        return $this->hasMany(EstateReport::class, 'estate_id');
    }

    /**
     * بازدیدهای ملک
     *
     * @return object
     */
    public function hits()
    {
        return $this->hasMany(EstateVisit::class, 'estate_id');
    }

    /**
     * پیام هایی که در رابطه با ملک وجود دارد: بطور مثال برای ویرایشها یا تغییر وضعیت میتوان پیام مناسب ثبت کرد
     *
     * @return object
     */
    public function messages()
    {
        return $this->morphMany('App\Model\Message', 'model');
    }

    /**
     * اختصاص ملک های ثبت شده به کارشناسان
     *
     * @return object
     */
    public function estateConfirmation()
    {
        return $this->hasMany(EstateConfirmation::class, 'estate_id');
    }

    /**
     * تصویر پیش فرض ملک
     *
     * @return object
     */
    public function coverImage()
    {

        if(!empty($this->image_cover)){
            return $this->image_cover;
        }

        $firstImage = $this->images->where('hidden','!=',1)->where('plan','!=',1)->where('is_360','!=',1)->where('cover', 1)->first();


        $coverImage = $firstImage && is_array($firstImage->dimension) && isset($firstImage->dimension['large']) ? asset('/upload/images/estate/'.$firstImage->year.'/'.$firstImage->month.'/'.$firstImage->dimension['large']): asset('/img/site'.ss('SITE_ID').'/estate'.$this->estate_type.rand(1,2).'.jpg');
        return $coverImage;
    }


    public function link_rewrite()
    {
        return str_replace(array('/','(',')',"/"),'-',$this->link_rewrite);
    }

    public function phone()
    {
        if(empty(\Auth::user()) || (\Auth::user() && !\Auth::user()->isExpert()) ){

            if(!empty($this->expert_id) && $this->expert && $this->expert->isExpert())
            {
                return (object)array('type' => 'expert' , 'id' => $this->expert_id, 'name' => $this->expert->fullname() , 'phone' => $this->expert->username );
            }

            else
            {

                if((ss('SITE_ID') == 3 && $this->city_id == 1) || ss('SITE_ID') == 5 || (ss('SITE_ID') == 2 && in_array($this->city_id , [594,92,440,25])))
                {

                    return (object)array('type' => 'bongah' ,'id' => 0 , 'name' => '' , 'phone' => '');
                }
                else
                {
                    return (object)array('type' => 'user' ,'id' => $this->user_id , 'name' => $this->owner_name , 'phone' => $this->phone);
                }
            }
        }
        elseif(\Auth::user()->isAdmin() || (\Auth::user()->isExpert() && $this->haveExpert() && \Auth::user()->id == $this->expert_id))
        {
            return (object)array(
                'type' => 'both' ,
                'id' => $this->expert_id,
                'name' =>$this->expert?$this->expert->fullname():'' ,
                'phone' => $this->expert?$this->expert->username:'' ,
                'id2' => $this->user_id ,
                'name2' => $this->owner_name ,
                'phone2' => $this->phone ,
                'phone3' => $this->phone2
            );
        }
        elseif(\Auth::user()->isExpert())
        {
            if(
                $this->percent_expert == 0 ||
                ($this->expert_id>0 && $this->expert && $this->expert->isExpert() && ($this->expiretime_expert == null || $this->expiretime_expert > date('Y-m-d H:i:s')) && (\Auth::user()->id == $this->expert_id  ||  (ss('SITE_ID') == 5 && $this->percent_expert != 50 && $this->percent_expert != 0))) ||
                ($this->expert_id == null || !$this->expert || !$this->expert->isExpert() || ($this->expiretime_expert != null && $this->expiretime_expert < date('Y-m-d H:i:s')))
            )
            {
                return (object)array('type' => 'user' ,'id' => $this->user_id , 'name' => $this->owner_name , 'phone' => $this->phone , 'phone2' => $this->phone2);
            }
            elseif($this->expert_id>0 && $this->expert && $this->expert->isExpert())
            {
                return (object)array('type' => 'expert' , 'id' => $this->expert_id, 'name' => $this->expert->fullname() , 'phone' => $this->expert->username);
            }


        }
    }
    public function haveExpert()
    {
        return $this->expert_id>0 && $this->expert && $this->expert->isExpert() && $this->percent_expert>0 && ($this->expiretime_expert == null || $this->expiretime_expert > date('Y-m-d H:i:s')) ;
    }
}
