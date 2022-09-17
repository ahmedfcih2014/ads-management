<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CategoriesCrudTest extends TestCase
{
    use RefreshDatabase ,WithFaker ,DatabaseMigrations;

    /**
     * @route-name categories.index
     * @return void
     */
    public function test_can_list_categories_successfully()
    {
        // Fake Data
        Category::factory()->count(5)->create();
        // Call API
        $response = $this->get(route('categories.index'));
        // Validate Response
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [ ['id', 'name', 'ads_count'] ]
        ]);
    }

    /**
     * @route-name categories.create
     * @return void
     */
    public function test_can_create_category_successfully()
    {
        $reqPayload = ['name' => $this->faker->name];

        $response = $this->post(route('categories.store'), $reqPayload);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => ['id', 'name']
        ]);
    }

    /**
     * @route-name categories.show
     * @return void
     */
    public function test_can_show_category_successfully()
    {
        // Fake Data
        $c = Category::factory(1)->create()->first();
        // Call API
        $response = $this->get(route('categories.show', ['category' => $c->id]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => ['id', 'name']
        ]);
    }

    /**
     * @route-name categories.update
     * @return void
     */
    public function test_can_update_category_successfully()
    {
        // Fake Data
        $c = Category::factory(1)->create()->first();

        $reqPayload = ['name' => $this->faker->name];
        // Call API
        $response = $this->put(route('categories.update', ['category' => $c->id]), $reqPayload);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => ['id', 'name']
        ]);
    }

    /**
     * @route-name categories.destroy
     * @return void
     */
    public function test_can_destroy_category_successfully()
    {
        // Fake Data
        $c = Category::factory(1)->create()->first();

        // Call API
        $response = $this->delete(route('categories.destroy', ['category' => $c->id]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => ['id', 'name']
        ]);
    }
}
