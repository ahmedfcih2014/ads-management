<?php

namespace App\Filters\AdsFilter;

use App\Contracts\FilterContract;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter implements FilterContract
{
    public function apply(Builder $query) : Builder
    {
        $categoryId = request()->get("category_id");
        return $query->when($categoryId , function ($q) use ($categoryId) {
            $q->where("category_id", $categoryId);
        });
    }
}
