<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractParties extends BaseModel
{
    /**
     * مشتریان دخیل در قولنامه
     *
     * @return string
     */
    protected $table = 'contract_parties';
    protected $fillable = [
        'contract_id',
        'type',
        'name',
        'address',
        'commission',
        'receipt_number',
        'receipt_doc',
        'description',
    ];

    /**
     * قولنامه ای که این مشتری خریدار یا فروشنده روی آن ثبت شده است
     *
     * @return object
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
