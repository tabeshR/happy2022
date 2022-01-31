<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::query();
        if ($key = $request->search) {
            $products->where('name', 'like', "%{$key}%");
        }
        $products = $products->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:250', 'min:2', Rule::unique('users')],
            'description' => ['required', 'max:1000', 'min:3'],
            'price' => ['integer'],
            'inventory' => ['integer'],
            'img' => ['required', 'max:1000'],
            'attribute' => 'nullable|array'
        ]);
        $file = $request->file('img');
        $data['img'] = $file->getClientOriginalName();
        $file->move(public_path('img'), $file->getClientOriginalName());
        $product = Product::create($data);
        $this->addAttributeToProduct($product, $data);

        alert()->success('محصول با موفقیت ثبت شد');
        return redirect(route('admin.products.index'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $data = $request->validate([
            'name' => ['required', 'max:250', 'min:2', Rule::unique('users')],
            'description' => ['required', 'max:1000', 'min:3'],
            'price' => ['integer'],
            'inventory' => ['integer'],
            'attribute' => 'nullable|array'
        ]);
//        $file = $request->file('img');
//        if ($file) {
//            $request->validate([
//                'img' => ['required', 'max:1000']
//            ]);
//            $data['img'] = $file->getClientOriginalName();
//            $file->move(public_path('img'), $file->getClientOriginalName());
//            if (File::exists(public_path('img/') . $product->img)) {
//                File::delete(public_path('img/') . $product->img);
//            }
//        }
        if(isset($data['attribute'])){
           $product->attributes()->detach();
            $this->addAttributeToProduct($product, $data);
        }
        $product->update($data);
        alert()->success('محصول با موفقیت ویرایش شد');
        return redirect(route('admin.products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back();
    }

    /**
     * @param Product $product
     * @param array $data
     */
    public function addAttributeToProduct(Product $product, array $data)
    {
        collect($data['attribute'])->map(function ($attr) use ($product) {
            if (is_null($attr['name']) || is_null($attr['value'])) {
                return;
            }
            $attribute = Attribute::firstOrCreate([
                'name' => $attr['name'],
            ]);
            $attribute_value = $attribute->values()->firstOrCreate([
                'value' => $attr['value']
            ]);
            $product->attributes()->attach($attribute->id, [
                'value_id' => $attribute_value->id
            ]);
        });
    }
}
