<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'integer',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'price',
    ];

    /**
     * @param $id
     * @param $name
     * @param $price
     * @return bool
     */
    public static function recordIsEmpty($id, $name, $price): bool
    {
        return self::query()
            ->where('user_id', $id)
            ->where('name', $name)
            ->where('price', $price)
            ->doesntExist();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param $id
     * @param $name
     * @param $price
     * @return int
     */
    public static function getProductId($id, $name, $price): int
    {
        return self::query()
            ->where('user_id', $id)
            ->where('name', $name)
            ->where('price', $price)
            ->value('id');
    }
}
