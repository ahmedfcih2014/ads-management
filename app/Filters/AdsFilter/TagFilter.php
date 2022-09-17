<?php

namespace App\Filters\AdsFilter;

use App\Contracts\FilterContract;
use Illuminate\Database\Eloquent\Builder;

class TagFilter implements FilterContract
{
    public function apply(Builder $query) : Builder
    {
        $tagId = request()->get("tag_id");
        return $query->when($tagId , function ($q) use ($tagId) {
            $q->whereHas("tags", function ($tagQuery) use ($tagId) {
                $tagQuery->where("tag_id", $tagId);
            });
        });
    }
}
