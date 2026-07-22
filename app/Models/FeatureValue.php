<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureValue extends Model
{
    /**
     * مقادیر امکانات ملک
     *
     * @return object
     */
    protected $table = 'feature_values';
    public $timestamps = false;
    protected $fillable = [
        'feature_id',
        'icon',
        'title',
        'apartment1',
        'villa1',
        'store1',
        'land1',
        'industrial1',
        'apartment2',
        'villa2',
        'store2',
        'land2',
        'industrial2',
    ];

    /**
     * امکانات ملک ای که مقدار مورد نظر در آن وجود دارد
     *
     * @return object
     */
    public function feature()
    {
        return $this->belongsTo(Feature::class, 'feature_id');
    }
}
