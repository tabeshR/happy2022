<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();
        if ($key = $request->search) {
            $products->where('name', 'like', "%{$key}%");
        }
        $products = $products->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function single(Product $product)
    {
        return view('products.single',compact('product'));
    }
}
