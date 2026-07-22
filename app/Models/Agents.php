<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Agents extends BaseModel
{
    protected $table = 'agents';
    protected $fillable = [
        'name',
        'mobile',
        'city',
        'senddate',
        'senddate2',
        'active',
        'gender'
    ];
    protected $hidden = ['created_at', 'updated_at'];


}
