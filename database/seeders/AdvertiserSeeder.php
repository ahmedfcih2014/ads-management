<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Advertiser;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class AdvertiserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::factory()->count(5)->create();
        Category::factory()->count(2)->create()
            ->map(function ($c) use ($tags) {
                Advertiser::factory()->count(2)
                    ->create()
                    ->map(function ($adv) use ($c, $tags) {
                        Ad::factory(3, [
                            'advertiser_id' => $adv->id,
                            'category_id' => $c->id
                        ])
                        ->create()
                        ->map(function ($a) use ($tags) {
                            $ids = $tags->random(2)->map(fn($t) => $t->id)->toArray();
                            $a->tags()->syncWithoutDetaching($ids);
                        });
                    });
            });
    }
}
