<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /***
     * @param $id
     * @param $name
     * @param $price
     * @return int
     */
    public static function generateProductId($id, $name, $price): int
    {
        if (Product::searchRecord($id, $name, $price))  {
            Product::create(['user_id' => $id, 'name' => $name, 'price' => $price]);
        }
        return Product::getProductId($id, $name, $price);
    }
}
