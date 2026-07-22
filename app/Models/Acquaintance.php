<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Acquaintance extends Model
{
	protected $table = 'acquaintance';
	protected $fillable = ['name'];
	protected $hidden = [ 'created_at', 'updated_at' ];

}
