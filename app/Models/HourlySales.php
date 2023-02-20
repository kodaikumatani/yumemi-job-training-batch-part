<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
        'dateTime',
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
    public static function recordIsEmpty($date, $hour, $user_id, $store_id, $product_id): bool
    {
        return self::query()
            ->where('dateTime', $date)
            ->where('hour', $hour)
            ->where('user_id', $user_id)
            ->where('store_id', $store_id)
            ->where('product_id', $product_id)
            ->doesntExist();
    }

    /**
     * @return Builder[]|Collection
     */
    public static function fetchLatestDailySale(): Collection|array
    {
        return self::query()
            ->select('user_id', 'store_id', 'product_id')
            ->selectRaw('max(quantity) as quantity')
            ->selectRaw('DATE_FORMAT(dateTime, "%Y-%m-%d") AS date')
            ->whereNotIn('dateTime', Sales::fetchExistDate())
            ->groupBy('date', 'user_id', 'store_id', 'product_id')
            ->get();
    }
}
