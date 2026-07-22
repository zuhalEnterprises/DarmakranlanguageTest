<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent_authentications extends Model
{
    protected $fillable=['Token','IdCode','Name','Family','FatherName','NationalId','Photo','Mobile','CardNumber1','Sheba1','Address','PostalCode'];

}
