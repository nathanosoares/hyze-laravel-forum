<?php

namespace App\Models\Chatter;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forum extends Model
{

    use SoftDeletes;

    protected $table = 'forums';
    public $timestamps = true;

    protected $fillable = ['name', 'slug', 'restrict_read', 'restrict_write', 'description'];

    protected $visible = [
        'id', 'name', 'slug', 'parent', 'category', 'restrict_read', 'restrict_write', 'children'
    ];

    protected $with = ['parent', 'category'];

    public function parent()
    {
        return $this->hasOne(self::class,'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class,'parent_id', 'id')
            ->orderBy('order');
    }

    public function threads()
    {
        return $this->hasMany(Thread::class,'forum_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}