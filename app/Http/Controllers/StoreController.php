<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /***
     * @param $id
     * @param $name
     * @return int
     */
    public static function generateStoreId($id, $name): int
    {
        if (Store::searchRecord($id, $name)) {
            Store::create(['user_id' => $id, 'name' => $name]);
        }
        return Store::getStoreId($id, $name);
    }
}
