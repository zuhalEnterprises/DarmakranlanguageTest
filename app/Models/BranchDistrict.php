<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchDistrict extends BaseModel
{
    /**
     *  محل های تحت پوشش شعبه
     *
     * @var string
     */
    protected $table = 'branch_districts';

    /**
     * لیست فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = [
        # شناسه شعبه
        'branch_id',
        # شناسه محله
        'district_id'
    ];

    /**
     * فیلدهایی که در زمان نمایش باید مخفی باشند
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * شعبه
     *
     * ارتباط از طریق کلید خارجی branch_id
     *
     * @return object
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     *  محله
     *
     * ارتباط از طریق کلید خارجی district_id
     *
     * @return object
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
