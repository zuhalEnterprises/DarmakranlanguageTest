<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AgentDistrict extends BaseModel
{
    protected $table = 'agentDistrict';
    protected $fillable = [
        'agent_id',
        'divar_id',
        'city',
        'street'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function agent()
    {
        return $this->belongsTo(Agents::class, 'agent_id');
    }
}
