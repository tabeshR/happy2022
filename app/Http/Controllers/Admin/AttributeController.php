<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function getValues(Request $request)
    {
        $attribute = Attribute::where('name',$request->name)->first();
        if($attribute){
            return response(['data'=>$attribute->values()->pluck('value')],200);
        }
        return response(['error'=>true],404);
    }
}
