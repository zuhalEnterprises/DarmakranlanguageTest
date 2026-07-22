<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractUser extends BaseModel
{
    /**
     * کارشناسان دخیل در قولنامه
     *
     * @return string
     */
    protected $table = 'contract_users';
    protected $fillable = [
        'contract_id',
        'expert_id',
        'reagent_id',
        'type',
        'expert_commission',
        'reagent_commission',
        'description',
    ];

    /**
     * قولنامه ای که این کارشناس در آن دخیل بوده است
     *
     * @return object
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
     * کارشناسی که در قولنامه دخیل بوده است
     *
     * @return object
     */
    public function expert()
    {
        return $this->belongsTo(User::class, 'expert_id');
    }

    /**
     * معرف کارشناسی که در قولنامه دخیل بوده است
     *
     * @return object
     */
    public function reagent()
    {
        return $this->belongsTo(User::class, 'reagent_id');
    }
}
