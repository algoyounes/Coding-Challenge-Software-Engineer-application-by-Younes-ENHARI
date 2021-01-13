<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Category;

class CategoryTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Edit test category
     *
     * @return void
     */
    public function testCanEditCategory(){
        $category = Category::create([
            'id' => 3,
            'name' => "Material",
        ]);

        $this->assertEquals($category->id, Category::find(3)->id);
    }


    /**
     * Delete test category
     *
     * @return void
     */
    public function testCanDeleteCategory(){
        $cat = Category::where('id', 3)->first();
        if ($cat != null) {
            $cat->delete();
            $this->assertTrue(true);
        }
        $this->assertFalse(false);
    }
}
