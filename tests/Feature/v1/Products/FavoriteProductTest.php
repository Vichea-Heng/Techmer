<?php

namespace Tests\Feature\v1\Products;

use App\Models\Products\Product;
use Tests\TestCase;
use App\Models\Users\User;
use Illuminate\Foundation\Testing\WithFaker;

class FavoriteProductTest extends TestCase
{
    use WithFaker;

    private $model = 'favorite-product';

    public function data_to_create()
    {
        return [
            "user_id" => 1,
            "product_id" => 1,
        ];
    }

    private $data_to_update = [
        "user_id" => 1,
        "product_id" => 1,
    ];

    private function all_factory()
    {
        factory(User::class, 1)->create();
        factory(Product::class, 1)->create();
    }

    public function test_index()
    {
        $this->test_store();

        $response = $this->get("v1/" . $this->model);

        $response->assertStatus(200);
    }

    // public function test_indexOnlyTrashed()
    // {
    //     $this->test_delete();

    //     $response = $this->get("v1/" . $this->model . "/indexOnlyTrashed");

    //     $response->assertStatus(200);
    // }

    public function test_store()
    {
        $this->all_factory();

        $response = $this->post('v1/' . $this->model, $this->data_to_create());

        $response->assertStatus(200);
    }

    public function test_show()
    {
        $this->all_factory();

        $response = $this->post('v1/' . $this->model, $this->data_to_create());

        $response = $this->get('v1/' . $this->model . '/1');

        $response->assertStatus(200);
    }

    // public function test_update()
    // {
    //     $this->all_factory();

    //     $response = $this->post('v1/' . $this->model, $this->data_to_create());

    //     $response = $this->put('v1/' . $this->model . '/1', $this->data_to_update);

    //     $response->assertStatus(200);
    // }

    public function test_delete()
    {
        $this->all_factory();

        $response = $this->post('v1/' . $this->model, $this->data_to_create());

        $response = $this->delete('v1/' . $this->model . '/1');

        $response->assertStatus(200);
    }

    // public function test_restore()
    // {
    //     $this->all_factory();

    //     $response = $this->post('v1/' . $this->model, $this->data_to_create());

    //     $response = $this->delete('v1/' . $this->model . '/1');

    //     $response = $this->post('v1/' . $this->model . '/restore/1');

    //     $response->assertStatus(200);
    // }

    // public function test_forceDelete()
    // {
    //     $this->all_factory();

    //     $response = $this->post('v1/' . $this->model, $this->data_to_create());

    //     $response = $this->delete('v1/' . $this->model . '/forceDelete/1');

    //     $response->assertStatus(200);
    // }
}
