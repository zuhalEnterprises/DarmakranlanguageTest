<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
    /**
     *  دسته بندی های بلاگ
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * فیلدهای قابل پذیرش در زمان ثبت یا ویرایش
     *
     * @var array
     */
    protected $fillable = [
        # شناسه دسته والد
        'parent_id',
        # نام فایل تصویر
        'image',
        # نام دسته
        'name',
        # توضیحات
        'description',
        # عنوان متا(سئو)
        'meta_title',
        # توضیحات متا(سئو)
        'meta_description',
        # کلمات کلیدی(سئو)
        'meta_keywords',
        # آدرس فارسی صفحه دسته بندی
        'link_rewrite',
        # جایگاه نمایش
        'position',
        # وضعیت نمایش: 1=فعال 0=غیرفعال
        'active'
    ];

    /**
     * فیلدهایی که در زمان نمایش باید مخفی باشند
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     *  دسته بندی والد
     *
     * ارتباط از طریق کلید خارجی parent_id
     *
     * @return object
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    /**
     * لیست دسته های فرزند
     *
     * ارتباط از طریق کلید خارجی parent_id
     *
     * @return object
     */
    public function childes()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    /**
     * لیست شناسه دسته های فرزند
     *
     * @return array
     */
    public function getChildes(&$childes = [])
    {
        $this->childes->each(function ($item) use (&$childes) {
            $childes[] = $item->id;
            $item->getChilds($childes);
        });

        return $childes;
    }

    /**
     * لیست شناسه دسته های والد
     *
     * @return array
     */
    public function getParent(&$parents = [])
    {
        $this->parent()->get()->each(function ($item) use (&$parents) {
            $parents[] = $item->id;
            $item->getParent($parents);
        });

        return $parents;
    }

    /**
     * حذف دسته های فرزند
     *
     * @return boolean
     */
    public function deleteChildes()
    {
        return $this->childes->each(function ($item) {
            $item->deleteChildes();
            $item->delete();
        });

        return true;
    }

    /**
     * نمایش دسته بندیها با ساختار درختی
     *
     * @return array
     */
    public function list2tree(array $list, $parentId = 'id', $parentKey = 'parent', $childKey = 'childes')
    {
        $tree = [];
        foreach ($list as $k => &$v) {
            ///>
            if ($v[$parentKey] == 0) {
                $tree[] =& $v;
            } else {
                if ($parentId === null) {
                    $list[$v[$parentKey]];
                } else {
                    foreach ($list as $k1 => &$v1) {
                        if ($v1[$parentId] == $v[$parentKey]) {
                            ///>
                            if (empty($v1[$childKey])) {
                                $v1[$childKey] = [&$v];
                            } else {
                                if (!is_array($v1[$childKey])) {
                                    $v1[$childKey] = [$v1[$childKey]];
                                }
                                $v1[$childKey][] =& $v;
                            }
                            break;
                        }
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * نمایش تمامی پست های یک دسته بندی
     *
     * ارتباط از طریق کلید خارجی category_id در جدول میانی posts_categories
     *
     * @return object
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'posts_categories', 'category_id', 'post_id')->withTimestamps();
    }

    /**
     * تصویر پست
     *
     * در صورتی که تصویر وجود داشته باشد لینک تصویر نهایی را برمیگرداند
     *
     * @return string
     */
    public function image()
    {
        return getImage($this->image);
    }
}
