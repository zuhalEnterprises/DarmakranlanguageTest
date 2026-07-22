<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpLogin extends BaseModel {
	protected $table = 'ip_login';
	protected $fillable = [
	    'ip',
        'user_id',
        'expire_date'
    ];
	public function user() {
		return $this->belongsTo( User::class, 'user_id' );
	}
}
