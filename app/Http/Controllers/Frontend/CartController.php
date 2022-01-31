<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        if(!\Cart::count()){
            return redirect('/');
        }
        return view('cart');
    }

    public function add(Product $product)
    {
     //  return \Cart::all();
        if(!\Cart::has($product)){
            \Cart::add(['quantity'=>1],$product);
        }else{
            \Cart::update($product,1);
        }
        return back();
    }

    public function update(Request $request)
    {
       $data = $request->validate([
            'id' => 'required',
            'quantity'=>'integer|required'
        ]);
        $data = (object)$data;
        if(\Cart::has($data)){
            \Cart::update($data,$data);
            return response(['success'=>true],200);
        }
        return response(['error'=>true],404);
    }

    public function destroy(Request $request)
    {
       $data = $request->validate([
            'id' => 'required',
        ]);
       $data = (object)$data;
       if(\Cart::has($data)){
           \Cart::deleteItem($data);
       }
       return back();
    }
}
