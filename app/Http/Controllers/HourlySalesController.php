<?php

namespace App\Http\Controllers;

use App\Models\HourlySales;
use App\Models\User;
use App\Service\ManageMailboxes;
use Google\Exception;
use Illuminate\Http\Request;

class HourlySalesController extends Controller
{
    /**
     * @return void
     * @throws Exception
     */
    public static function storeFlashSales(): void
    {
        foreach(ManageMailboxes::getMessage() as $message) {
            $user_id = User::getUserId($message['producer_name']);
            $store_id = StoreController::generateStoreId($user_id, $message['store_name']);
            $product_id = ProductController::generateProductId($user_id, $message['product_name'], $message['price']);
            $hour = self::roundTime(strtotime($message['date']));
            if (HourlySales::searchRecord($message['date'], $hour, $user_id, $store_id, $product_id)) {
                HourlySales::create([
                    'date' => $message['date'],
                    'hour' => $hour,
                    'user_id' => $user_id,
                    'store_id' => $store_id,
                    'product_id' => $product_id,
                    'quantity' => $message['quantity'],
                ]);
            }
        }
    }

    /**
     * @param $date
     * @return string
     */
    public static function roundTime($date): string
    {
        $minutes = round(date('i', $date) / 60) * 60;
        $time = mktime(date('H', $date), $minutes);
        return date('H',$time);
    }
}
