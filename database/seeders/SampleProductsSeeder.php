<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class SampleProductsSeeder extends Seeder
{
    public function run(): void
    {
        OrderItem::query()->delete();
        Order::query()->delete();
        Favorite::query()->delete();
        Product::query()->delete();

        $items = [
            [
                'id' => 1,
                'name' => '鉛筆',
                'description' => '描きやすい鉛筆です',
                'price' => 200,
                'stock' => 10,
            ],
            [
                'id' => 3,
                'name' => 'イヤホン',
                'description' => 'ワイヤレスです。',
                'price' => 1000,
                'stock' => 10,
            ],
            [
                'id' => 4,
                'name' => 'タブレット',
                'description' => '軽量です',
                'price' => 25000,
                'stock' => 10,
            ],
            [
                'id' => 5,
                'name' => 'デスク',
                'description' => '昇降できます',
                'price' => 30000,
                'stock' => 10,
            ],
        ];

        foreach ($items as $item) {
            Product::create($item);
        }
    }
}
