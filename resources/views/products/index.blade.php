@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h4> محصولات فروشگاه</h4>
            </div>
        </div>
        <hr>
        <div class="row">
            @foreach($products as $product)
                <div class="col-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <a href="{{ asset('img/'.$product->img) }}">
                                        <img src="{{ asset('img/'.$product->img) }}" alt="" class="img-circle"
                                             style="width: 200px;height:200px;margin: 0 auto;display: block">
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col my-3 text-center">
                                    {{ $product->name }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    قیمت :
                                    {{ $product->price }}
                                    تومان
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3 text-center">
                                    موجودی :
                                    {{ $product->inventory }}
                                    عدد
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3">
                                    <a href="{{ route('products.single',$product->id) }}"
                                       class="float-left btn btn-primary btn-sm">جزئیات</a>
                                    <a href="{{ route('add-to-cart',$product->id) }}"
                                       class="float-right btn btn-danger btn-sm">
                                        <i class="fa fa-shopping-cart
"></i>
                                        خرید
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
