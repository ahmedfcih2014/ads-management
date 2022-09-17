<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\Tag;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagsCrudTest extends TestCase
{
    use RefreshDatabase ,WithFaker ,DatabaseMigrations;

    /**
     * @route-name tags.index
     * @return void
     */
    public function test_can_list_tags_successfully()
    {
        // Fake Data
        Tag::factory()->count(5)->create();
        // Call API
        $response = $this->get(route('tags.index'));
        // Validate Response
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [ ['id', 'name'] ]
        ]);
    }

    /**
     * @route-name tags.create
     * @return void
     */
    public function test_can_create_tag_successfully()
    {
        $reqPayload = ['name' => $this->faker->name];

        $response = $this->post(route('tags.store'), $reqPayload);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => ['id', 'name']
        ]);
    }

    /**
     * @route-name tags.show
     * @return void
     */
    public function test_can_show_tag_successfully()
    {
        // Fake Data
        $t = Tag::factory(1)->create()->first();
        // Call API
        $response = $this->get(route('tags.show', ['tag' => $t->id]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => ['id', 'name']
        ]);
    }

    /**
     * @route-name tags.update
     * @return void
     */
    public function test_can_update_tag_successfully()
    {
        // Fake Data
        $t = Tag::factory(1)->create()->first();

        $reqPayload = ['name' => $this->faker->name];
        // Call API
        $response = $this->put(route('tags.update', ['tag' => $t->id]), $reqPayload);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => ['id', 'name']
        ]);
    }

    /**
     * @route-name tags.destroy
     * @return void
     */
    public function test_can_destroy_tag_successfully()
    {
        // Fake Data
        $t = Tag::factory(1)->has(Ad::factory()->count(2))->create()->first();

        // Call API
        $response = $this->delete(route('tags.destroy', ['tag' => $t->id]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => ['id', 'name']
        ]);
    }
}
