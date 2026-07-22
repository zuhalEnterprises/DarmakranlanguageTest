<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAppointment extends Model
{
    protected $table = 'customer_appointment';

    protected $fillable = [
        'name',
        'lang_id',
        'date',
        'mobile',
        'country_id',
        'email',
        'estate_id',
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // ارتباط با کشور
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    // ارتباط با ملک
    public function estate()
    {
        return $this->belongsTo(Estate::class, 'estate_id');
    }
}
