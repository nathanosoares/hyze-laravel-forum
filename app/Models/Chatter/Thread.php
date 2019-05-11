<?php

namespace App\Models\Chatter;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'id', 'title', 'slug', 'forum', 'author', 'main_post', 'created_at'
    ];

    protected $with = ['author'];

    protected $appends = ['main_post'];

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
}