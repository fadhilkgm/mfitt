<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category(){
       return $this->belongsTo('App\Models\Category');
    }
    public function unit(){
        return $this->belongsTo('App\Models\Unit');
    }
    public function tax(){
        return $this->belongsTo('App\Models\Tax');
    }

    public function additionalProduct(){
        return $this->hasMany('App\Models\ProductSupplier');
    }

    public function sale(){
        return $this->hasMany('App\Models\Sale');
    }

    public function invoice(){
        return $this->belongsToMany('App\Invoice');
    }
}
