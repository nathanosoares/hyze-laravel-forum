<?php

namespace App\Models\Forums;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forum extends Model
{

    use SoftDeletes;

    protected $table = 'forums';
    public $timestamps = true;

    protected $fillable = [
        'category_id', 'name', 'slug', 'restrict_read', 'restrict_write',
        'description', 'threads_restrict_read', 'threads_restrict_write',
        'threads_restrict_move', 'threads_restrict_close', 'threads_fallback_forum_id',
    ];

    protected $visible = [
        'id', 'name', 'slug', 'parent', 'category', 'restrict_read', 'restrict_write',
        'children', 'multimoderations'
    ];

    // protected $with = ['parent', 'category'];

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->orderBy('order');
    }

    public function threads()
    {
        return $this->hasMany(Thread::class, 'forum_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function template()
    {
        return $this->hasOne(Thread::class, 'id', 'template_thread_id');
    }

    public function fallback()
    {
        return $this->hasOne(Forum::class, 'id', 'threads_fallback_forum_id');
    }

    public function multimoderations()
    {
        return $this->belongsToMany(MultiModeration::class, 'forum_multimoderation_pivot', 'forum_id', 'multimoderation_id');
    }

    /**
     * Scope a query to only include allowed forums to current user.
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
                $query->orWhereIn('restrict_read', $currentHighestGroup->sameOrLower()->pluck('key'));
            }
        });
    }
}
