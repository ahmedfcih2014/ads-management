<?php

namespace App\Traits;

use App\Contracts\FilterContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait Filters
{
    public static function filters(Collection $filters, Builder $query) : Builder {
        $filters->filter(function ($f) {
            return $f instanceof FilterContract;
        })
        ->each(function ($filter) use (&$query) {
            $query = $filter->apply($query);
        });
        return $query;
    }
}
