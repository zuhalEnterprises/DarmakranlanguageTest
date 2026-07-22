<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends BaseModel
{
    /**
     * زبان ها
     *
     * @return string
     */
    protected $table = 'countries';
    protected $fillable = [
        'name',
        'name_short',
        'phone_code'
    ];
    protected $hidden = ['created_at', 'updated_at'];

}
