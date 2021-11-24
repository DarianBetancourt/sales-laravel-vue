<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Address;
use App\Models\Product;
use Carbon\Carbon;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::all();
        
        $i=0;
        foreach ($sales as $sale) {
            $sales[$i]->address=$sale->address;
            $sales[$i]->products=$sale->products;
            foreach ($sale->products as $product) {
                $sales[$i]->total+=$product->pivot->total;
            }
            $i++;
        }
        
        return response()->json($sales); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $res = $request->all();
        $addressExist=Address::where('cep','=',$res['address']['cep'])->first();

        if($addressExist === null){
            $address=new Address;
            $address->cep = $request->address->cep;
            $address->state = $request->address->state;
            $address->city = $request->address->city;
            $address->neighborhood = $request->address->neighborhood;
            $address->street = $request->address->street;
            $address->save();
        }else{
            $address=$addressExist;
        }
        $sale = new Sale;
        $sale->date=Carbon::now();
        $address->sales()->save($sale);

        $products=$res['products'];

        foreach ($products as $product) {
            $sale->products()->attach([
                    $product['id'] => [
                        'price' => $product['price'],
                        'amount' => $product['amount'],
                        'total' => $product['total']
                    ]
            ]);
        }
        return response()->json([
            "message" => "success"
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return response()->json($sale);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Sale $sale)
    {
        $sale->fill($request->post())->save();
        return response()->json([
            'sale'=>$sale,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return response()->json([
            'message'=>'sale deleted'
        ]);
    }
}
