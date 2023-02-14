<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourlySales extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'hour',
        'user_id',
        'store_id',
        'product_id',
        'price',
        'quantity',
    ];

    /**
     * @param $date
     * @param $hour
     * @param $user_id
     * @param $store_id
     * @param $product_id
     * @return bool
     */
    public static function searchRecord($date, $hour, $user_id, $store_id, $product_id): bool
    {
        return self::query()
            ->where('date', $date)
            ->where('hour', $hour)
            ->where('user_id', $user_id)
            ->where('store_id', $store_id)
            ->where('product_id', $product_id)
            ->doesntExist();
    }

}
