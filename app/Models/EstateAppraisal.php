<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstateAppraisal extends Model
{
    /**
     * یادداشت های ملک
     *
     * @return string
     */
    protected $table = 'estate_appraisal';
    protected $fillable = [
        'name',
        'estate_type',
        'tel',
        'address'
    ];
    protected $hidden = ['created_at', 'updated_at'];


}
