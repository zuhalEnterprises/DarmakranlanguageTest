<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Contact extends Model
{
    /**
     * تماس های کاربران یا انتقادات و پیشنهادات
     *
     * @var string
     */
    protected $table = 'contacts';
    protected $fillable = ['user_id', 'name', 'email', 'mobile', 'message', 'status'];
    protected $hidden = ['updated_at'];

    /**
     * کاربر ارسال کننده فرم
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
