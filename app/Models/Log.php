<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dateTime',
        'producer_code',
        'producer',
        'store',
        'product',
        'price',
        'quantity',
    ];

    /**
     * @return array
     */
    public static function fetchUpdatedSales(): array
    {
        return self::query()
            ->select('dateTime', 'producer_code', 'store', 'product', 'price')
            ->selectRaw('quantity -
                COALESCE(
                    (
                        LAG(quantity) OVER (
                            PARTITION BY store, product, price
                            ORDER BY dateTime
                        )
                    ),
                    0
                ) as subtotal')
            ->whereDate('dateTime', date('Y-m-d'))
            ->get()
            ->toArray();
    }
}
