<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;

class AttributeProduct extends Pivot
{
    public function value()
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
