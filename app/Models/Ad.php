<?php

namespace App\Models;

use App\Filters\AdsFilter\CategoryFilter;
use App\Filters\AdsFilter\TagFilter;
use App\Traits\Filters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Ad extends Model
{
    use HasFactory ,Filters;

    protected $fillable = [
        'advertiser_id', 'type', 'title', 'description', 'category_id', 'start_date'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function advertiser() {
        return $this->belongsTo(Advertiser::class, 'advertiser_id');
    }

    public function tags() {
        return $this->belongsToMany(
            Tag::class,
            'ad_tags',
            'ad_id',
            'tag_id'
        );
    }

    public static function getFilters() : Collection {
        return collect([
            new TagFilter(),
            new CategoryFilter(),
        ]);
    }
}
