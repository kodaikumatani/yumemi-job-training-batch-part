<?php

namespace App\Http\Controllers;

use App\Models\HourlySales;
use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * @return void
     */
    public static function storeDailySales(): void
    {
        foreach(HourlySales::fetchLatestDailySales() as $record) {
            $date = $record['date'];
            $user_id = $record['user_id'];
            $store_id = $record['store_id'];
            $product_id = $record['product_id'];
            if (Sales::recordIsEmpty($date, $user_id, $store_id, $product_id)) {
                Sales::create([
                    'date' => $date,
                    'user_id' => $user_id,
                    'store_id' => $store_id,
                    'product_id' => $product_id,
                    'quantity' => $record['quantity'],
                ]);
            }
        }
    }
}
