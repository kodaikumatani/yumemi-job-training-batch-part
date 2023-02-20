<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Store extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
    ];

    /**
     * @param $id
     * @param $name
     * @return bool
     */
    public static function recordIsEmpty($id, $name): bool
    {
        return self::query()
            ->where('user_id', $id)
            ->where('name', $name)
            ->doesntExist();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param $id
     * @param $name
     * @return int
     */
    public static function getStoreId($id, $name): int
    {
        return self::query()
            ->where('user_id', $id)
            ->where('name', $name)
            ->value('id');
    }
}
