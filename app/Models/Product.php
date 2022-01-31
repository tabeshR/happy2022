<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'img','name','description','price','inventory','view_count'
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withPivot(['value_id'])->using(AttributeProduct::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class);
    }
}
