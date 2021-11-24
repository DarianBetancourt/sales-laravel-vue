<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public $timestamps = false;
    //uno a muchos invertido
    /**
     * Get address
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    //Relacion muchos a muchos

    /**
     * Get products
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('price', 'amount','total');
    }

}
