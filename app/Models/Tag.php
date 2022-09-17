<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function ads() {
        return $this->hasManyThrough(
            Ad::class,
            AdTag::class,
            'tag_id',
            'id',
            'id',
            'ad_id'
        );
    }

    public function nonDeleteable() {
        return $this->ads->count() > 0;
    }
}
