<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id','status','price','res_number'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
