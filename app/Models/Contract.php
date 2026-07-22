<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Traits\HasRoles;
use Verta;

class Contract extends BaseModel
{
    use HasRoles;
    protected $guard_name = 'web';

    /**
     * قولنامه ها
     *
     * @return string
     */
    protected $table = 'contracts';
    protected $fillable = [
    "user_id",
    "type",
    "estate_type",
    "contractid",
    "registryofficedate",
    "deliverydate",
    "tracking_code",
    "total_commission",
    "description",
    "estate_id",
    "estate_name",
    "estate_phone",
    "estate_fatherName",
    "estate_idCard",
    "estate_nationalId",
    "estate_address",
    "total_price",
    "total_mortgage",
    "total_rent",
    "customer_id",
    "customer_name",
    "customer_phone",
    "customer_fatherName",
    "customer_idCard",
    "customer_nationalId",
    "register_at"
    ];

    /**
     * فیلدهایی که باید به تاریخ تبدیل شوند
     *
     * @var array
     */
    protected $dates = ['register_at', 'deletion_at', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];

    public function typeName()
    {
        $name = '';
        switch($this->type){
            case 1: $name='خرید و فروش'; break;
            case 2: $name='اجاره'; break;
            case 3: $name='ناموفق'; break;
            case 4: $name='مشارکت در ساخت'; break;
            case 5: $name='تهاتر'; break;
            default:
                $name = '';
        }
        return $name;
    }

    /**
     * کارشناسان قولنامه
     *
     * @return object
     */
    public function contractUsers()
    {
        return $this->hasMany(ContractUser::class, 'contract_id');
    }

    /**
     * مشتریان دخیل در قولنامه
     *
     * @return object
     */
    public function contractParties()
    {
        return $this->hasMany(ContractParties::class, 'contract_id');
    }
    public function contractDocument()
    {
        return $this->hasMany(ContractDocument::class, 'contract_id');
    }

    /**
     * تغییرات قولنامه
     *
     * @return object
     */
    public function contractModifications()
    {
        return $this->hasMany(ContractModification::class, 'contract_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    /**
     * استان ملک مورد معامله در قولنامه
     *
     * @return object
     */
    public function estateProvince()
    {
        return $this->belongsTo(Province::class, 'estate_province_id');
    }

    /**
     * شهر ملک مورد معامله در قولنامه
     *
     * @return object
     */
    public function estateCity()
    {
        return $this->belongsTo(City::class, 'estate_city_id');
    }

    /**
     * محله ملک مورد معامله در قولنامه
     *
     * @return object
     */
    public function estateDistrict()
    {
        return $this->belongsTo(District::class, 'estate_district_id');
    }

    /**
     * شعبه ای که قولنامه در آن تنظیم شده است
     *
     * @return object
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }



    /**
     * کاربر ثبت کننده قولنامه
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * مدیر شعبه
     *
     * @return object
     */
    public function branchManager()
    {
        return $this->belongsTo(User::class, 'branch_manager_id');
    }

    /**
     * مدیر قرارداد
     *
     * @return object
     */
    public function contractManager()
    {
        return $this->belongsTo(User::class, 'contract_manager_id');
    }

    /**
     * تاریخچه قولنامه : مثل ثبت یا تغییر وضعیت
     *
     * @return object
     */
    public function histories()
    {
        return $this->hasMany(ContractHistory::class, 'contract_id');
    }

    /**
     * اخرین وضعیت قولنامه
     *
     * @return object
     */
    public function statusHistory()
    {
        return $this->histories->where('type', 'status')->sortByDesc('id')->first() ?? null;
    }

    /**
     * درآمد های قولنامه
     *
     * @return object
     */
    public function earnings()
    {
        return $this->hasMany(ContractEarning::class, 'contract_id');
    }

    /**
     * فیلتر براساس تاریخ ثبت قولنامه : برای نمونه در لیست قولنامه های بخش مدیریت انجام شده است
     *
     * @param $query
     * @param $date
     *
     * @return Builder
     */
    // start date
    public function scopeStartDate(Builder $query, $date): Builder
    {
        $datetime = Carbon::createFromTimestamp($date);

        return $query->whereDate('register_at', '>=', $datetime);
    }

    // end date
    public function scopeEndDate(Builder $query, $date): Builder
    {
        $datetime = Carbon::createFromTimestamp($date);

        return $query->whereDate('register_at', '<=', $datetime);
    }
}
