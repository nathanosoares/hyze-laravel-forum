<?php

namespace App\Models\Forums;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Category extends Model
{

    use SoftDeletes;

    protected $table = 'categories';
    public $timestamps = true;
    protected $fillable = ['name', 'slug', 'restrict_read', 'restrict_write'];
    //    public $with = 'children';

    //    public function parent()
    //    {
    //        return $this->hasOne(self::class,'id', 'parent_id');
    //    }

    //    public function children()
    //    {
    //        return $this->hasMany(self::class,'parent_id', 'id');
    //    }

    public function forums()
    {
        return $this->hasMany(Forum::class, 'category_id')->orderBy('order');
    }

    /**
     * Scope a query to only include allowed categories to current user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAllowed($query)
    {
        $currentHighestGroup  = optional(auth()->user())->highest_group;

        return $query->where(function ($query) use ($currentHighestGroup) {

            $query->where('restrict_read', null);

            if (auth()->user()) {
                $query->orWhereIn('restrict_read', $currentHighestGroup->sameOrLower()->map(function ($item) {
                    return $item->key;
                }));
            }
        });
    }
}
