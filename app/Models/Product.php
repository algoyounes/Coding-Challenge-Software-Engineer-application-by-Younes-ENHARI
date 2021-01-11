<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Product can belong to one category
     *
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }


    // Function delete all category on relation with product in case of deleting product
    public static function boot() {
        parent::boot();
        self::deleting(function($product) {
            $product->categories()->detach();
        });
    }

}
