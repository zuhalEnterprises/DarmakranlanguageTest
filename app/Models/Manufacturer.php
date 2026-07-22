<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends BaseModel {

	protected $table = 'manufacturer';
	protected $fillable = [ 'name', 'post_id' ];
	protected $hidden = [ 'created_at', 'updated_at' ];


	public function projects() {
		return $this->hasMany( Project::class, 'manufacturer_id' );
	}
    public function post() {
		return $this->belongsTo( Post::class, 'post_id' );
	}
}
