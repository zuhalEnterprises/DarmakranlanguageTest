<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class error_log extends Model
{
    protected $fillable=['id','message','code','file','line','createdate','userid','url','ip'];

}