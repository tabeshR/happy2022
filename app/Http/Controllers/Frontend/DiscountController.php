<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function check(Request $request)
    {
        $data =$request->validate(['code'=>'required|exists:discounts,code']);
        $discount = Discount::whereCode($data['code'])->first();
        if($discount){
            if($discount->expired_at < now()){
                return back()->withErrors(['code'=>'کد وارد شده منقضی شده است']);
            }
            if(!$discount->users->count() || in_array($request->user()->id,$discount->users->pluck('id')->toArray())){
               \Cart::addDiscount($discount->code);
               return back();
            }else{
                return back()->withErrors(['code'=>'شما مجوز استفاده از این کد را ندارد']);
            }
        }
        return back()->withErrors(['code'=>'کد وارد شده معتبر نمیباشد']);
    }

    public function deleteDiscount()
    {
        \Cart::addDiscount(null);
        return back();
    }
}
