<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;
    protected $fillable = ['address1', 'address2', 'city', 'governorate', 'customer_id'];
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
