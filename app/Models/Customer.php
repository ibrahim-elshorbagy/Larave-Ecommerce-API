<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Http\Enums\AddressType;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [ 'phone', 'status','user_id'];
    public $timestamps = false;
    protected $primaryKey = 'user_id';
    public function user(){
        return $this->belongsTo(User::class);
    }

}
