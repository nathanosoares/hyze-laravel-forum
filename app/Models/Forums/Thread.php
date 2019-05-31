<?php

namespace App\Models\Forums;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Extensions\Permission\GroupCache;

class Thread extends Model
{

    use SoftDeletes;

    protected $table = 'threads';
    public $timestamps = true;
    protected $fillable = ['title', 'forum_id', 'user_id', 'slug', 'restrict_read', 'restrict_write'];
    protected $dates = ['deleted_at', 'last_reply_at'];
    protected $casts = [
        'promoted' => 'boolean',
        'sticky' => 'boolean',
        'closed' => 'boolean'
    ];

    protected $visible = [
        'id', 'title', 'slug', 'forum', 'author', 'main_post',
        'created_at', 'replies_count', 'promoted', 'sticky',
        'restrict_write', 'restrict_read', 'closed'
    ];

    protected $with = ['author'];

    protected $appends = ['main_post', 'replies_count'];

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'thread_id');
    }

    public function replies()
    {
        return $this->hasMany(Post::class, 'thread_id')->where('parent_id', null);
    }

    public function getRepliesCountAttribute()
    {
        if (isset($this->attributes['replies_count'])) {
            return $this->attributes['replies_count'];
        }

        $count = $this->replies()->count() - 1;

        $this->attributes['replies_count'] = $count;

        return $count;
    }

    public function getMainPostAttribute()
    {
        return once(function () {
            return $this->posts()->first();
        });
    }

    public function getLastPostAttribute()
    {
        return once(function () {
            return $this->posts()->latest()->first();
        });
    }

    /**
     * Scope a query to only include allowed threads to current user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAllowed($query)
    {
        $currentHighestGroup  = optional(auth()->user())->highest_group;

        $allowedForumsToReadIds = resolve(GroupCache::class)
            ->getAllowedForumsToRead($currentHighestGroup)
            ->pluck('id');

        return $query->where(function ($query) use ($currentHighestGroup) {
            $query->where('restrict_read', null);

            if (!is_null($currentHighestGroup)) {
                $query->orWhereIn('restrict_read', $currentHighestGroup->sameOrLower()->pluck('key'));
            }

            if (auth()->user()) {
                $query->orWhere('user_id', auth()->user()->id);
            }
        })->whereIn('forum_id', $allowedForumsToReadIds);
    }
}
