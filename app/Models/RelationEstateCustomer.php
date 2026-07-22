<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationEstateCustomer extends BaseModel
{
    protected $table = 'relation_estate_customer';

    protected $fillable = [
        'estate_id',
        'customer_id',
        'seen_estate',
        'seen_customer',
        'estate_expert_id',
        'customer_expert_id',
        'estate_comment',
        'customer_comment',
        'send_at',
        'deleted_at',
        'user_id',
        'status',
        'priority'
    ];

    protected $dates = ['created_at','updated_at'];

    public function estate()
    {
        return $this->belongsTo(Estate::class, 'estate_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function estate_expert()
    {
        return $this->belongsTo(User::class, 'estate_expert_id');
    }
    public function customer_expert()
    {
        return $this->belongsTo(User::class, 'customer_expert_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function strstatus()
    {
        $arr = array(0=>'جدید' , 1=>'رد شده' ,2=>'تائید شده' ,3=>'ارسال شده' );
        if(array_key_exists($this->status , $arr))
        {
            return $arr[$this->status];
        }
        else
        {
            return "";
        }
    }
    public function strpriority()
    {
        $arr = array(0=>'برنزی' , 1=>'نقره‌ای' ,2=>'طلایی');
        if(array_key_exists($this->priority , $arr))
        {
            return $arr[$this->priority];
        }
        else
        {
            return "";
        }
    }
}
