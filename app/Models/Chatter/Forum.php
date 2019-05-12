<?php

namespace App\Models\Chatter;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Forum extends Model implements Sluggable
{

    use SoftDeletes;

    protected $table = 'forums';
    public $timestamps = true;

    protected $visible = [
        'id', 'name', 'slug', 'parent', 'category', 'restrict_read', 'restrict_write'
    ];

    protected $with = ['parent', 'category'];

    public function parent()
    {
        return $this->hasOne(self::class,'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class,'parent_id', 'id');
    }

    public function threads()
    {
        return $this->hasMany(Thread::class,'forum_id')->orderBy('created_at', 'desc');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getRoute(): string
    {
        return route('chatter.forum', [$this->slug, $this->id]);
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }
}