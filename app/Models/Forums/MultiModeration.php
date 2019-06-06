<?php

namespace App\Models\Forums;

use Illuminate\Database\Eloquent\Model;

class MultiModeration extends Model
{
    protected $table = 'multimoderations';
    public $timestamps = true;

    public function scopeAllowed($query)
    {
        $currentHighestGroup  = optional(auth()->user())->highest_group;

        return $query->where(function ($query) use ($currentHighestGroup) {
            $query->where('restrict_use', null);

            if (!is_null($currentHighestGroup)) {
                $query->orWhereIn('restrict_use', $currentHighestGroup->sameOrLower()->pluck('key'));
            }
        });
    }
}
