<?php

namespace App\Models\Chatter;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
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
}