<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class ContractHistory extends Model
{
    use HasRoles;
    protected $guard_name = 'web';
    /**
     * تاریخچه قولنامه : ثبت و تغییر وضعیت
     *
     * @return string
     */
    protected $table = 'contract_histories';
    protected $fillable = [
        'user_id',
        'contract_id',
        'type',
        'description',
        'platform',
        'browser',
        'ip',
        'contract_archived',
        'contract_status',
    ];
    protected $dates = ['created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * قولنامه ای که برای آن تاریخچه ثبت شده است
     *
     * @return object
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
     * کاربری که زمان ثبت ناریخجه دخیل بوده است
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
