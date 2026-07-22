<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractModification extends BaseModel
{
    /**
     * تغییرات قولنامه
     *
     * @return string
     */
    protected $table = 'contract_modifications';
    protected $fillable = [
        'contract_id',
        'sender_id',
        'receiver_id',
        'description',
    ];

    /**
     * قولنامه ای که روی آن تغییرات ثبت شده است
     *
     * @return object
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
