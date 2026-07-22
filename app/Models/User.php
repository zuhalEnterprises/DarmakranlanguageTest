<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\LogOptions;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable implements MustVerifyEmail
{
    use SoftDeletes, Notifiable, HasRoles, CausesActivity, LogsActivity, LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email']); // فقط فیلدهایی که می‌خواهید در لاگ ثبت شوند
    }
    protected $guard_name = 'web';

    /**
     * مشخص کردن فیلدهایی که زمان تغییر یا ثبت در سیستم لاگ ثبت شود
     */
    protected static $logAttributes = ['*'];

    /**
     * ثبت لاگ برای تغییرات بعد از بروزرسانی
     */
    protected static $logOnlyDirty = true;

    /**
     * زمان ثبت لاگ نام لاگ از نام کلاس گرفته میشود
     */
    public function getLogNameToUse(): string
    {
        return basename(__CLASS__);
    }


    /**
     * کاربران: اعضای سیستم و کاربران سایت
     *
     * همه کاربران با هر نقش کاربری در این جدول نگه داری میشود
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * فیلدهای قابل پذیرش در زمان ثبت و ویرایش
     *
     * @var array
     */
    protected $fillable = [
        'is_admin',
        'province_id',
        'city_id',
        'district_id',
        'parent_id',
        'code',
        'name',
        'last_name',
        'father_name',
        'title',
        'alias',
        'alias_status',
        'username',
        'email',
        'password',
        'gender',
        'phone',
        'profile_cover',
        'photo',
        'photoStatus',
        'birthday',
        'national_code',
        'bio',
        'acquaintance_type',
        'experience',
        'experience_date',
        'military_status',
        'marital_status',
        'activity_type',
        'activity_estate_type',
        'address',
        'token',
        'notification_token',
        'push_id',
        'status',
        'has_role',
        'role_ids',
        'last_login',
        'last_ip',
        'active',
        'verified_at',
        'wallet_balance',
        'wallet_blocked',
        'last_activity',
        'change_password',
        'message',
        'authentication_token',
        'is_authenticated',
        'has_password',
        'status_bio',
        'temp_bio',
        'video',
        'header',
        'operand',
        'price',
        'commission',
        'eitaa',
        'whatsapp',
        'instagram',
        'telegram',
        'branch_id',
        'isbongah',
        'label'
    ];

    /**
     * فیلدهایی که باید از لیست مخفی شوند
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * فیلدهایی که باید به تاریخ تبدیل شوند
     *
     * @var array
     */
    protected $dates = ['verified_at', 'experience_date', 'created_at', 'updated_at'];

    /**
     *  برای جستجو در لیست های مدیریت و همچنین جهت تمیز بودن کد از این متد کمکی و همچنین پکیج Spatie\QueryBuilder استفاده شده است
     * البته بعضی از لیست ها بصورت دستی کنترل میشود ، برای نمونه جستجو در لیست املاک در مدیریت ، استفاده از پکیج برای شرایط خاص میسر نبود
     *
     * @param array $inputs فیلدهای کلاس مدل موردنظر
     * @param null $inputsAppends فیلدهای اضافه اختیاری برای جستجو در لیست
     * @return array
     */
    public function getFilters($inputs, $inputsAppends = null)
    {
        $filters = [];
        $fields = array_merge(['id', 'created_at'], $this->getFillable());
        foreach ($fields as $field) {
            $filters["filter[$field]"] = $inputs[$field] ?? '';
        }

        if (!empty($inputsAppends)) {
            foreach ($inputsAppends as $field) {
                $filters["filter[$field]"] = $inputsAppends[$field] ?? '';
            }
        }

        return $filters;
    }
    public function authentications()
    {
        return $this->hasone(agent_authentications::class, 'idCode','authentication_token');

    }


    /**
     * وضعیت فعال بودن کاربر دارای نقش
     *
     * @return boolean
     */
    public function isActive()
    {

        return $this->has_role == 1 && $this->active == 1  ? true : false;
    }

    /**
     * بررسی وضعیت دارا بودن دسترسی مدیرکل سیستم بصورت دستی در جدول با فیلد is_admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        /*if(ss('SITE_ID') == 3 && $this->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator')){
            $iplogin = IpLogin::where('ip', getIp())->where('expire_date','>', date('Y-m-d H:i:s'))->first();
            if($iplogin == null){
                return false;
            }
        }*/
        return $this->isActive() && $this->hasRole('admin_super') ? true : false;
    }

    /**
     * بررسی وضعیت دارا بودن نقش سوپر ادمین یا مدیرکل سیستم بصورت دستی
     *
     * @return boolean
     */
    public function isAdminSuper()
    {
        /*if(ss('SITE_ID') == 3 && $this->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator')){
            $iplogin = IpLogin::where('ip', getIp())->where('expire_date','>', date('Y-m-d H:i:s'))->first();
            if($iplogin == null){
                return false;
            }
        }*/
        return $this->isAdmin() || $this->hasRole('admin_super') ? true : false;
    }

    /**
     * بررسی وضعیت دارا بودن نقش مدیرسایت
     *
     * @return boolean
     */
    public function isAdminSite()
    {
        /*if(ss('SITE_ID') == 3 && $this->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator')){
            $iplogin = IpLogin::where('ip', getIp())->where('expire_date','>', date('Y-m-d H:i:s'))->first();
            if($iplogin == null){
                return false;
            }
        }*/
        return $this->isActive() && $this->hasRole('admin_site') ? true : false;
    }

    /**
     * بررسی وضعیت دارا بودن نقش مدیر شعبه
     *
     * @return boolean
     */
    public function isAdminBranch()
    {
        /*if(ss('SITE_ID') == 3 && $this->hasAnyRole('admin_super|admin_site|admin_financial|admin_marketing|admin_branch|expert|operator')){
            $iplogin = IpLogin::where('ip', getIp())->where('expire_date','>', date('Y-m-d H:i:s'))->first();
            if($iplogin == null){
                return false;
            }
        }*/
        return $this->isActive() && $this->hasRole('admin_branch') ? true : false;
    }

    /**
     * بررسی وضعیت دارا بودن نقش کارشناسی
     *
     * @return boolean
     */
    public function isReferrer()
    {
        return $this->isActive() && $this->hasAnyRole('expert' ,'admin_super' , 'admin_branch' , 'referrer') ? true : false;
    }

    public function isExpert()
    {
        return $this->isActive() && $this->hasAnyRole('expert' ,'admin_super' , 'admin_branch') ? true : false;
    }

    public function isRenter()
    {
        $user = \Auth::user();
        return $this->isActive() && $this->hasAnyRole('renter') && $this->status==1? true : false;
    }

    /**
     * بررسی وضعیت دارا بودن نقش کارشناسی
     *
     * @return boolean
     */
    public function isAgent()
    {
        $user = \Auth::user();
        /*if(ss('SITE_ID') == 3 && isset($user) && $user->id == $this->id){
            $iplogin = IpLogin::where('ip', getIp())->where('expire_date','>', date('Y-m-d H:i:s'))->first();
            if($iplogin == null){
                return false;
            }
        }*/
        return $this->isActive() && $this->hasRole('agent') ? true : false;
    }

    /**
     * بررسی وضعیت دارا بودن نقش مدیر مالی سیستم
     *
     * @return boolean
     */
    public function isAdminFinancial()
    {
        $user = \Auth::user();
        /*if(ss('SITE_ID') == 3 && isset($user) && $user->id == $this->id){
            $iplogin = IpLogin::where('ip', getIp())->where('expire_date','>', date('Y-m-d H:i:s'))->first();
            if($iplogin == null){
                return false;
            }
        }*/
        return $this->isActive() && $this->hasRole('admin_financial') ? true : false;
    }

    /**
     * بررسی وضعیت دارا بودن نقش مدیر بازاریابی
     *
     * @return boolean
     */
    public function isAdminMarketing()
    {
        return $this->isActive() && $this->hasRole('admin_marketing') ? true : false;
    }

    /**
     * بررسی وضعیت دارا بودن نقش اپراتور سایت
     *
     * @return boolean
     */
    public function isOperator()
    {
        return $this->isActive() && $this->hasRole('operator') ? true : false;
    }

    /**
     * بررسی وضعیت دارا بودن نقش مدیر حقوقی
     *
     * @return boolean
     */
    public function isAdminLegal()
    {
        $user = \Auth::user();
        /*if(ss('SITE_ID') == 3 && isset($user) && $user->id == $this->id){
            $iplogin = IpLogin::where('ip', getIp())->where('expire_date','>', date('Y-m-d H:i:s'))->first();
            if($iplogin == null){
                return false;
            }
        }*/
        return $this->isActive() && $this->hasRole('admin_legal') ? true : false;
    }

    /**
     * بررسی وضعیت دارا بودن یکی از نقش های سیستم
     *
     * @return boolean
     */
    public function isMember()
    {
        $user = \Auth::user();
        if(ss('SITE_ID') == 3 && isset($user) && $user->id == $this->id){
            return true;
        }

        return false;
    }

    /**
     * بررسی وضعیت کاربر نهایی سایت بدون داشتن هیچ نقشی
     *
     * @return boolean
     */
    public function isEndUser()
    {
        return $this->is_admin == 0 && $this->active == 1 && $this->status == 1 ? true : false;
    }

    /**
     * متد کمکی جهت گرفتن نقش یا نقش های کاربر
     *
     * @return string
     */
    public function getRole()
    {
        $user = \Auth::user();
        /*if(ss('SITE_ID') == 3 && isset($user) && $user->id == $this->id){
            $iplogin = IpLogin::where('ip', getIp())->where('expire_date','>', date('Y-m-d H:i:s'))->first();
            if($iplogin == null){
                return null;
            }
        }*/
        if ($this->isAdmin()) {
            return 'admin_super';
        }

        $roleIds = !empty($this->role_ids) ? json_decode($this->role_ids) : [];
        rsort($roleIds);
        $finalRoleId = count($roleIds) > 0 ? end($roleIds) : 0;
        $role = Role::find($finalRoleId);

        if (!$role) {
            return null;
        }

        return $role->name;
    }

    /**
     * متد کمکی جهت گرفتن عنوان بالاترین سطح از نقشهای کاربر : بطورمثال اگر کاربری همزمان 2 نقش داشته باشد نقشی که در بالاترین سطح|اولیت قرار دارد برگشت داده میشود
     *
     * @return string
     */
    public function getRoleTitle()
    {
        $user = \Auth::user();
        /*if(ss('SITE_ID') == 3 && isset($user) && $user->id == $this->id){
            $iplogin = IpLogin::where('ip', getIp())->where('expire_date','>', date('Y-m-d H:i:s'))->first();
            if($iplogin == null){
                return null;
            }
        }*/
        if ($this->isAdmin()) {
            return 'مدیر کل';
        }

        $roleIds = !empty($this->role_ids) ? json_decode($this->role_ids) : [];
        rsort($roleIds);
        $finalRoleId = count($roleIds) > 0 ? end($roleIds) : 0;
        $role = Role::find($finalRoleId);

        if (!$role) {
            return null;
        }

        return $role->title;
    }



    /**
     * استانی که کاربر در آن عضو شده است
     *
     * @return object
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    /**
     * شهری که کاربر در آن عضو شده است
     *
     * @return object
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * محل های فعالیت کارشناس
     *
     * @return object
     */
    public function districts()
    {
        return $this->belongsToMany(District::class, 'user_activity_districts', 'user_id', 'district_id')->withPivot('selection_count', 'ratio')->withTimestamps();
    }

    /**
     * ملک های کاربر
     *
     * @return object
     */
    public function estates()
    {
        return $this->hasMany(Estate::class, 'expert_id');
    }



    /**
     * مشتریانی که کاربر ثبت کرده است
     *
     * @return object
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'user_id');
    }


    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }



    /**
     * لاگین های کاربران با نوع کد ورود از طریق پیامک
     *
     * @return object
     */
    public function logins()
    {
        return $this->hasMany(UserLogin::class, 'user_id');
    }


    /**
     * لیست ملک های علاقه مند شده
     *
     * @return object
     */
    public function favoriteEstates()
    {
        return $this->belongsToMany(Estate::class, 'estate_favorites', 'user_id', 'estate_id')->withPivot('pin')->withTimestamps();
    }

        /**
     * لیست ملک های قابل مقایسه
     *
     * @return object
     */
    public function compareEstates()
    {
        return $this->belongsToMany(Estate::class, 'estate_compare', 'user_id', 'estate_id')->withPivot('pin')->withTimestamps();
    }

    /**
     * لیست مشتریان علاقه مند شده
     *
     * @return object
     */
    public function favoriteCustomer()
    {
        return $this->belongsToMany(Customer::class, 'customer_favorites', 'user_id', 'customer_id')->withTimestamps();
    }

    /**
     * لیست کارشناسان علاقه مند شده
     *
     * @return object
     */
    public function favoriteExperts()
    {
        return $this->belongsToMany(User::class, 'expert_favorites', 'user_id', 'expert_id')->withPivot('pin')->withTimestamps();
    }


    /**
     * آدرس نهایی تصویر پروفایل
     *
     * @return string
     */
    public function photo()
    {
        // اگر photo یک URL کامل بود، مستقیم برگردان
        if (!empty($this->photo) && filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }

        // اگر photo فایل محلی است
        $img = !empty($this->photo)
            ? 'profile/' . $this->photo
            : (!empty($this->gender)
                ? ($this->gender == 'male' || $this->gender == 1 ? 'avatar_man.png' : 'avatar_women.png')
                : 'avatar_man.png');

        return getImage($img);
    }


    /**
     * آدرس نهایی تصویر کاور صفحه شخصی
     *
     * @return string
     */
    public function cover()
    {
        $img = !empty($this->profile_cover) ? 'profile/' . $this->profile_cover : $this->profile_cover;
        return getImage($img);
    }

    /**
     * کاربر معرف
     *
     * @return object
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }

    /**
     * ادغام نام و نام خانوادگی کاربر
     *
     * @return string
     */
    public function fullname($gender = 0)
    {
        $gender = '';
        if($gender == 1 && $this->gender != null){

            $gender = $this->gender == 1 ? 'آقای':'خانم';
        }
        if($this->title != '' && false)
        {
            return $gender. ' '. $this->title;
        }
        else
        {
            if(!empty($this->isbongah) && $this->isbongah==1)
            {
                return $gender. ' '. $this->name . ' ' . $this->last_name."(مشاور املاک)";
            }
            return $gender. ' '. $this->name . ' ' . $this->last_name;
        }

    }

    /**
     * لیست جستجوهای کاربر
     *
     * @return object
     */
    public function searches()
    {
        return $this->hasMany(UserSearch::class, 'user_id');
    }

    /**
     * لیست زبان هایی که کاربر به آنها تسلط دارد
     *
     * @return object
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'user_languages');
    }

    /**
     * کامنت هایی که کاربر ثبت روی کارشناس یا شعبه ثبت کرده است
     *
     * @return object
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'commentable_id');
    }

    public function getLevel()
    {
        $agent = User::whereHas('parent')->withCount('childes')
            ->with([
                'parent'=>function($q){
                    $q->whereHas('childes')->withCount('childes');
                },
                'parent.parent'=>function($q){
                    $q->whereHas('childes')->withCount('childes');
                },
                'parent.parent.parent'=>function($q){
                    $q->whereHas('childes')->withCount('childes');
                },
                'parent.parent.parent.parent'=>function($q){
                    $q->whereHas('childes')->withCount('childes');
                },
                'parent.parent.parent.parent.parent'=>function($q){
                    $q->whereHas('childes')->withCount('childes');
                }
            ])->find($this->id);

        $listLevels = [];

        $parent1 = $agent->parent ?? null;
        if(!empty($parent1) && $parent1->childes_count){
            $listLevels[1] = [
                'id' => $parent1->id,
                'userLevel' => 'معرف سطح 1',
                'childesCount' => $parent1->childes_count,
                'commissionPercent'=>3
            ];
        }

        $parent2 = $parent1->parent ?? null;
        if(!empty($parent2) && $parent2->childes_count > 4 ){
            $listLevels[2] = [
                'id' => $parent2->id,
                'userLevel' => 'معرف سطح 2',
                'childesCount' => $parent2->childes_count,
                'commissionPercent'=> 0.5
            ];
        }

        $parent3 = $parent2->parent ?? null;
        if(!empty($parent3) && $parent2->childes_count >= 10){
            $listLevels[3] = [
                'id' => $parent3->id,
                'userLevel' => 'معرف سطح 3',
                'childesCount' => $parent3->childes_count,
                'commissionPercent'=> 0.5
            ];
        }

        $parent4 = $parent3->parent ?? null;
        if(!empty($parent4) && $parent2->childes_count >= 20){
            $listLevels[4] = [
                'id' => $parent4->id,
                'userLevel' => 'معرف سطح 4',
                'childesCount' => $parent4->childes_count,
                'commissionPercent'=> 0.5
            ];
        }

        $parent5 = $parent4->parent ?? null;
        if(!empty($parent5) && $parent2->childes_count > 40 ){
            $listLevels[5] = [
                'id' => $parent5->id,
                'userLevel' => 'معرف سطح 5',
                'childesCount' => $parent5->childes_count,
                'commissionPercent'=> 0.5
            ];
        }


        return $listLevels;
    }
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail());
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
}
