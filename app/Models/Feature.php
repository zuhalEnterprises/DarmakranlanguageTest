<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    /**
     * امکانات و شرایط ملک
     *
     * @return string
     */
    protected $table = 'features';
    protected $fillable = [
        'group',
        'title',
        'title_en',
        'sale',
        'rent',
        'required',
        'multiple',
        'position',
        'agent_visible'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * مقادیر امکانات ملک
     *
     * @return object
     */
    public function values()
    {
        return $this->hasMany(FeatureValue::class);
    }
}
