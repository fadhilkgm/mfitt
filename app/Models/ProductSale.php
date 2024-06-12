<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    public function product(){
        return $this->belongsTo('App\Models\Product');
    }

    public function sale(){
        return $this->belongsTo('App\Models\Sale');
    }
}
