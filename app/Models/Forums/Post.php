<?php

namespace App\Models\Forums;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class Post extends Model implements Auditable
{

    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable = ['thread_id', 'user_id', 'body'];
    protected $dates = ['deleted_at'];
    protected $casts = [
        'body' => 'array',
    ];

    protected $visible = [
        'id', 'body', 'author', 'replies_count', 'created_at', 'body_parsed', 'parent'
    ];

    protected $appends = ['replies_count', 'body_parsed'];

    protected $with = ['author', 'parent'];

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getBodyParsedAttribute()
    {
        $body = $this->body;

        return once(function () use ($body) {
            return markconverter($body);
        });
    }

    public function getRepliesCountAttribute()
    {
        return $this->replies()->count();
    }

    public static function createNew(User $user, Thread $thread, string $body, Post $parent = null): Post
    {
        if ($parent) {
            $post = $parent->replies()->create([
                'user_id' => $user,
                'thread_id' => $thread->id,
                'body' => $body
            ]);

            return $post;
        }

        $thread->last_reply_at = now();
        $thread->save();

        // Merge post
        //        if ($thread->last_post->parent == null && $thread->last_post->author->id === Auth::user()->id) {
        //            $thread->last_post->body .= "\n\n" . $request->body;
        //
        //            $thread->last_post->save();
        //
        //            return $thread->last_post;
        //        }



        return $thread->posts()->create([
            'user_id' => Auth::user()->id,
            'body' => $body
        ]);
    }

    public static function fromRequest(Request $request, Thread $thread, Post $parent = null): Post
    {
        return self::createNew(auth()->user->id, $thread, $request->body, $parent);
    }
}
