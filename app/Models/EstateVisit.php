<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstateVisit extends Model
{
    /**
     * بازدیدهای ملک
     *
     * @return string
     */
    protected $table = 'estate_visits';
    protected $fillable = [
        'estate_id',
        'visit_count',
    ];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * ملک بازدید شده
     *
     * @return object
     */
    public function estate()
    {
        return $this->belongsTo(Estate::class, 'estate_id');
    }
}
