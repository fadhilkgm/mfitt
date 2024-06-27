<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_no',
        'customer_id',
        'total',
        'paid',
        'balance',
        'payment_method',
        'date',
        'discount',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function sales(){
        return $this->hasMany(Sale::class);
    }
}
