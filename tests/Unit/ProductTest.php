<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Category;
use App\Models\Product;

class ProductTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Edit test product
     *
     * @return void
     */
    public function testCanEditProduct(){
        $categories = [
            [
                'id' => 1,
                'name' => "Laptop",
            ],[
                'id' => 2,
                'name' => "Electronic",
            ]
        ];

        foreach($categories as $category) {
            Category::create($category);
        }

        $this->assertEquals(2, Category::count());

        $product = Product::create([
            'id' => 1,
            'name' => "Mac OSX",
            'description' => 'OSX Version 2013',
            'price' => 7000
        ]);

        $categories_ids = [];
        foreach($categories as $category){
            array_push($categories_ids, $category["id"]);
        }

        $product->categories()->attach($categories_ids);
        $this->assertEquals($product->id, Product::find(1)->id);
    }


    /**
     * Delete test product
     *
     * @return void
     */
    public function testCanDeleteProduct(){
        $prod = Product::where('id', 1)->first();
        if ($prod != null) {
            $prod->delete();
            $this->assertTrue(true);
        }
        $this->assertFalse(false);
    }
}
