<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

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
            Ad::class,
            'ad_tags',
            'ad_id',
            'tag_id'
        );
    }
}
