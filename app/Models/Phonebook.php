<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phonebook extends BaseModel
{
    /**
     * زبان ها
     *
     * @return string
     */
    protected $table = 'phonebook';
    protected $fillable = [
        'name',
        'phone',
        'description',
        'createdBy',
        'private'
    ];
    protected $hidden = ['created_at', 'updated_at'];

}
