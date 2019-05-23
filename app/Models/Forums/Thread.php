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
    protected $fillable = ['title', 'forum_id', 'user_id', 'slug', 'promoted'];
    protected $dates = ['deleted_at', 'last_reply_at'];
    protected $casts = [
        'promoted' => 'boolean',
    ];

    protected $visible = [
        'id', 'title', 'slug', 'forum', 'author', 'main_post', 'created_at', 'replies_count', 'promoted', 'sticky'
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
        $groupCache = resolve(GroupCache::class);
        $currentHighestGroup  = optional(auth()->user())->highest_group;

        $allowedForumsToRead = $groupCache->getAllowedForumsToRead($currentHighestGroup);

        $allowedForumsToReadIds = $allowedForumsToRead->map(function ($item) {
            return $item->id;
        });

        return $query->where(function ($query) use ($currentHighestGroup) {
            if (auth()->user()) {
                $query->orWhere('user_id', auth()->user()->id)
                    ->orWhere('restrict_read', null)
                    ->orWhereIn('restrict_read', $currentHighestGroup->sameOrLower()->map(function ($item) {
                        return $item->key;
                    }));
            } else {
                $query->where('restrict_read', null);
            }
        })->whereIn('forum_id', $allowedForumsToReadIds);
    }
}
