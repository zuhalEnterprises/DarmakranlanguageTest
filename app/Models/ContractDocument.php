<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;


class ContractDocument extends Model
{

    /**
     * تصاویر ملک
     *
     * @return string
     */
    protected $table = 'contract_documents';

    /**
     * فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = ['contract_id', 'name','extension','url','month','year'];

    /**
     * فیلدهایی که باید مخفی شوند
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     *  فیلدهایی که به تاریخ تبدیل میشوند
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * فیلدهایی که باید به یک نوع دیگر تبدیل شوند
     *
     * @var array
     */

    /**
     * ملکی که تصویر موردنظر به آن تعلق دارد
     *
     * @return object
     */
    public function contract()
    {
        return $this->belongsTo(contract::class, 'contract_id');
    }

    public function url()
    {
        if($this->year != '' && $this->month != '')
        {
            return $this->year.'/'.$this->month.'/'.$this->url;
        }
        else
        {
            return $this->url;
        }

    }
}
