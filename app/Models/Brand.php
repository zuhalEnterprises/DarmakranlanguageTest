<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends BaseModel {

	protected $table = 'brand';
	protected $fillable = [ 'name', 'post_id' ];
	protected $hidden = [ 'created_at', 'updated_at' ];

    public function post() {
		return $this->belongsTo( Post::class, 'post_id' );
	}
}
