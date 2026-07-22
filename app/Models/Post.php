<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Cache;
use Hekmatinasser\Verta\Verta;

class Post extends BaseModel {
	use HasRoles;
	protected $guard_name = 'web';

    /**
     * پست های بلاگ
     *
     * @return string
     */
	protected $table = 'posts';
	protected $fillable = [
		'type',
		'image',
		'title',
        'description',
		'body',
        'video',
		'meta_title',
		'meta_description',
		'link_rewrite',
		'visit',
		'active',
        'access_expert',
        'category_id',
        'expire_at'
	];
	protected $hidden = [ 'updated_at' ];

    /**
     * لیست دسته بندی های یک پست
     *
     * @return object
     */
	public function category(){
		return $this->belongsTo(Category::class, 'category_id');
	}

    /**
     * لیست تگ های یک پست
     *
     * @return object
     */
	public function tags() {
        $id = $this->id;
        return Cache::remember('posttags-'.$id , 3000, function () use ($id){
		    return Tag::join('taggables', 'tags.id', '=', 'taggables.tag_id')
                    ->where('taggable_id',$id)->where('taggable_type' , 'App\Model\Post')
                    ->select('tags.*')
                    ->get();
        });
	}

    /**
     * لیست کامتن های یک پست
     *
     * @return object
     */
	public function comments() {
		return $this->morphMany( 'App\Model\Comment', 'commentable' );
	}

    /**
     * آدرس نهایی تصویر پست
     *
     * @return string
     */
    public function image()
    {
        return getImage($this->image);
    }
    public function url()
    {
        if($this->category_id == 9)
        {
            return "/area/".$this->id."/".str_replace(array('/','(',')',"/",' '),'-',trim($this->title));
        }
        elseif($this->category_id == 10)
        {
            return "/city/".$this->id."/".str_replace(array('/','(',')',"/",' '),'-',trim($this->title));
        }
        else
        {
            return "/blog/".$this->id."/".str_replace(array('/','(',')',"/",' '),'-',trim($this->title));
        }
    }
    public function img()
    {
        if($this->image != '')
        {
            return "/upload/images/blog/".$this->image;
        }
        else
        {
            return '/img/noimage.png';
        }
    }


    /**
     * فیلتر براساس تاریخ ثبت
     *
     * @param $query
     * @param $date
     *
     * @return Builder
     */
    // filters scope
    // creation date
	public function scopeCreateDate( $query, $date ) {
		$datetime = Verta::parse( $date )->DateTime()->format( 'Y-m-d H:i:s' );

		return $query->whereDate( 'created_at', $datetime );
	}
}
