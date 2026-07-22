<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstateOperation extends Model
{
    /**
     * یادداشت های ملک
     *
     * @return string
     */
    protected $table = 'estate_operations';
    protected $fillable = [
        'expert_id',
        'estate_id',
        'comment',
        'customer_id',
        'type'
    ];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * کاربری که برای ملک یادداشت ثبت کرده است
     *
     * @return object
     */
    public function expert()
    {
        return $this->belongsTo(User::class, 'expert_id');
    }

    /**
     * ملک ای که به بروی آن یادداشت ثبت شده است
     *
     * @return object
     */
    public function estate()
    {
        return $this->belongsTo(Estate::class, 'estate_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function typeName()
    {
        switch($this->type){
            case 1: $name='کارشناسی'; break;
            case 2: $name='سرویس'; break;
            case 3: $name='آگهی'; break;
            case 4: $name='توضیحات'; break;
            case 5: $name='نردبان'; break;
            case 6: $name='فروش ویژه'; break;
            case 7: $name='قرار بازدید'; break;

            case 11: $name='تماس با مشتری'; break;
            case 12: $name='نظر مشاورین'; break;
            case 13: $name='فروش ویژه'; break;
            case 14: $name='حذف کارشناس'; break;
            case 15: $name='ارجاع به کارشناس'; break;
            case 16: $name='تغییر کارشناس'; break;
            case 17: $name='واتساپ با مشتری'; break;

        }
        return $name;
    }
}

