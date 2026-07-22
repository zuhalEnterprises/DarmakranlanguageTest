<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metavalue extends Model
{
    /**
     * این مدل به همراه جدول بعد از بررسی حذف شود
     *
     * @return object
     */
    public $timestamps = false;
    protected $table = 'metavalue';
    protected $fillable = ['title','type','kind','sale','deleted'];
}
