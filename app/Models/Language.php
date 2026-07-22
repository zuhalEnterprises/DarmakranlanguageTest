<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends BaseModel
{
    /**
     * زبان ها
     *
     * @return string
     */
    protected $table = 'languages';
    protected $fillable = [
        'name',
        'name_en',
        'abbreviation',
    ];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * کارشناسانی که به زبان موردنظر تسلط دارند
     *
     * @return object
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_languages');
    }
}
