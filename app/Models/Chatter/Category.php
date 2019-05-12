<?php

namespace App\Models\Chatter;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Category extends Model implements Sluggable
{

    use SoftDeletes;

    protected $table = 'categories';
    public $timestamps = true;
    public $with = 'children';

    public function parent()
    {
        return $this->hasOne(self::class,'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class,'parent_id', 'id');
    }

    public function forums()
    {
        return $this->hasMany(Forum::class,'category_id');
    }

    public function getItemsAttribute(): Collection
    {
        $children = $this->children;

        return $children->merge($this->forums)
            ->sortBy('order');
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
        return route('chatter.category', [$this->slug]);
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }
}