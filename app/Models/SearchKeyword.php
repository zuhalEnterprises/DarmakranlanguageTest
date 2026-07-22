<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class SearchKeyword extends BaseModel {
	use HasRoles;
	public $timestamps = false;
	protected $guard_name = 'web';

    /**
     * عبارات جستجو شده در سایت : این مدل با حالت ذخیره جستجوی ملک متفاوت است
     */
	protected $table = 'search_keywords';
	protected $fillable = [
        'user_id',
        'ip',
        'keyword'
    ];

    /**
     * کاربر جستجو کننده
     *
     * @return object
     */
	public function user() {
		return $this->belongsTo( User::class, 'user_id' );
	}
}
