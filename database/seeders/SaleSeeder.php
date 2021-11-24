<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\Product;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 6; $i++) {
            $sale = new Sale();
            $sale->address_id = $i;         
            $sale->date = Carbon::now();            
            $sale->save();

            foreach (range(1, 3) as $prod) {

                $amount=rand(1,5);
                $product=Product::find($prod);

                DB::table('product_sale')->insert([
                    'sale_id' => $i,
                    'product_id' =>$product->id,
                    'price' => $product->price,
                    'amount' => $amount,
                    'total' => $product->price*$amount,
                ]);
                
            }

        } 
        
    }
}
