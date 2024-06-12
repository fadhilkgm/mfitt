<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSupplier extends Model
{

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }

    public function supplier(){
        return $this->belongsTo('App\Models\Supplier');
    }


}
