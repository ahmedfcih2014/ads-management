<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\Advertiser;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\ArrayShape;
use Tests\TestCase;

class AdsTest extends TestCase
{
    use RefreshDatabase ,WithFaker ,DatabaseMigrations;

    /**
     * @route-name ads.filter
     * @return void
     */
    public function test_can_filter_ads_with_empty_data_successfully()
    {
        // Fake Data
        $f = $this->fakeAds();
        $c = $f['category'];
        $t = $f['tag'];

        // Call API
        $response = $this->get(route('ads.filter', ['category_id' => $c->id, 'tag_id' => $t->id]));

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEmpty($response->json()['data']);
    }

    /**
     * @route-name ads.filter
     * @return void
     */
    public function test_can_filter_ads_successfully()
    {
        // Fake Data
        $f = $this->fakeAds(true);
        $c = $f['category'];
        $t = $f['tag'];

        // Call API
        $response = $this->get(route('ads.filter', ['category_id' => $c->id, 'tag_id' => $t->id]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure($this->adsResource());
    }

    /**
     * @route-name advertiser.ads
     * @return void
     */
    public function test_can_get_advertiser_ads_successfully()
    {
        // Fake Data
        $f = $this->fakeAds();
        $a = $f['advertiser'];

        // Call API
        $response = $this->get(route('advertiser.ads', ['id' => $a->id]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure($this->adsResource());
    }

    #[ArrayShape([
        'tag' => "\Illuminate\Database\Eloquent\Model|mixed",
        'category' => "\Illuminate\Database\Eloquent\Model|mixed",
        'advertiser' => "\Illuminate\Database\Eloquent\Model|mixed"
    ])]
    private function fakeAds($forFirst = false) : array {
        $categories = Category::factory()->count(2)->create();
        $tags = Tag::factory()->count(2)->create();
        $advertiser = Advertiser::factory()->count(1)->create()->first();
        Ad::factory(10, [
            'category_id' => $categories->first()->id,
            'advertiser_id' => $advertiser->id
        ])
        ->create()
        ->each(function ($ad) use (&$tags) {
            $ad->tags()->sync([$tags->first()->id]);
        });
        return [
            'tag' => $forFirst ? $tags->first() : $tags->last(),
            'category' => $forFirst ? $categories->first() : $categories->last(),
            'advertiser' => $advertiser
        ];
    }

    private function adsResource() : array {
        return [
            'data' => [
                [
                    'id', 'type', 'title', 'description', 'start_date',
                    'category' => ['id', 'name', 'ads_count'],
                    'tags' => [['id', 'name', 'ads_count']],
                    'advertiser' => ['id', 'name'],
                ]
            ],
            'total',
            'per_page'
        ];
    }
}
