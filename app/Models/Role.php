<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // You might set a public property like guard_name or connection, or override other Eloquent Model methods/properties
    /**
     * نقش های کاربری
     *
     * @return string
     */
    protected $table = 'roles';
    protected $fillable = [
        # نام لاتین نقش کاربری
        'name',
        # عنوان فارسی نقش کاربری
        'title',
        # کمیسیون پیش فرض برای نقش
        'commission',
        # نوع محافظت در درخواست ها : web یا api
        'guard_name',
    ];
}
