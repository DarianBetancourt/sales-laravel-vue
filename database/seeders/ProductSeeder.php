<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $code=10000;
        //seeding products
        $product = new Product();
        $product->code=$code++;
        $product->name='farinha de trigo';
        $product->reference='trigo1kg';
        $product->price=4.50;
        $product->save();

        $product2 = new Product();
        $product2->code=$code++;
        $product2->name='pasta';
        $product2->reference='pasta500g';
        $product2->price=5.50;
        $product2->save();

        $product3 = new Product();
        $product3->code=$code++;
        $product3->name='arroz';
        $product3->reference='arroz1kg';
        $product3->price=5.00;
        $product3->save();

        $product4 = new Product();
        $product4->code=$code++;
        $product4->name='ovos frango branco';
        $product4->reference='ovobranco30u';
        $product4->price=4.50;
        $product4->save();

        $product5 = new Product();
        $product5->code=$code++;
        $product5->name='sal';
        $product5->reference='sal1kg';
        $product5->price=2.50;
        $product5->save();

    }
}
