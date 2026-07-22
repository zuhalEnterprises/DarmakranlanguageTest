<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractEarning extends Model
{
    /**
     * درآمدهای قولنامه
     *
     * @return string
     */
    protected $table = 'contract_earnings';
    public $fillable = [
        'contract_id',
        'expert_id',
        'user_id',
        'role_id',
        'user_level',
        'commission_percent',
        'commission_amount'
    ];

    /**
     * قولنامه
     *
     * @return object
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
     * کارشناس دخیل در قولناممه
     *
     * @return object
     */
    public function expert()
    {
        return $this->belongsTo(User::class, 'expert_id');
    }

    /**
     * کاربر
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * نقش کاربر
     *
     * @return object
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
