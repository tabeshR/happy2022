@extends('layouts.app')

@section('content')
    <div class="container px-3 clearfix">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h2>سبد خرید</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered m-0">
                                <thead>
                                <tr>
                                    <!-- Set columns width -->
                                    <th class="text-center py-3 px-4" style="min-width: 400px;">نام محصول</th>
                                    <th class="text-right py-3 px-4" style="width: 150px;">قیمت واحد</th>
                                    <th class="text-center py-3 px-4" style="width: 120px;">تعداد</th>
                                    <th class="text-right py-3 px-4" style="width: 150px;">قیمت نهایی</th>
                                    <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#" class="shop-tooltip float-none text-light" title="" data-original-title="Clear cart"><i class="ino ion-md-trash"></i></a></th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse(\Cart::all() as $cart)
                                    @php
                                        $product = $cart['product']
                                    @endphp
                                    <tr>
                                        <td class="p-4">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <a href="#" class="d-block text-dark">{{ $product->name }}</a>
                                                </div>
                                            </div>
                                        </td>

                                        @if($cart['discount_percent'])
                                            <td class="text-right font-weight-semibold align-middle p-4">
                                                <del>{{ $product->price }}</del>
                                                <span class="text-success">
                                                    {{ $product->price - ($product->price*$cart['discount_percent']) }}
                                                تومان
                                                </span>
                                            </td>
                                            @else
                                            <td class="text-right font-weight-semibold align-middle p-4">{{ $product->price }}
                                                تومان
                                            </td>
                                            @endif
                                        <td class="align-middle p-4">
                                            <select onchange="updateCart(event,'{{ $cart['id'] }}')" name="" class="form-control text-center">
                                                @foreach(range(1,$product->inventory) as $item)
                                                    <option
                                                        {{ $item == $cart['quantity'] ? "selected"  :"" }}
                                                        value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        @if($cart['discount_percent'])
                                            <td class="text-right font-weight-semibold align-middle p-4">

                                                <span class="text-success">
                                                    {{ ($product->price - ($product->price*$cart['discount_percent'])) * $cart['quantity'] }}
                                                تومان
                                                </span>
                                            </td>
                                        @else
                                            <td class="text-right font-weight-semibold align-middle p-4">{{ $product->price * $cart['quantity'] }}
                                                تومان
                                            </td>
                                        @endif

                                        <td class="text-center align-middle px-0"><a href="#" onclick="event.preventDefault();document.getElementById('cart-'+'{{ $cart["id"] }}').submit()" class="shop-tooltip close float-none text-danger" title="" data-original-title="Remove">×</a>
                                            <form action="{{ route('cart.destroy') }}" method="post" id="cart-{{ $cart['id'] }}">
                                                <input type="hidden" name="id" value="{{ $cart['id'] }}">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                        <!-- / Shopping cart table -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                            <div class="mt-4"></div>
                            <div class="d-flex">
                                {{--                        <div class="text-right mt-4 mr-5">--}}
                                {{--                            <label class="text-muted font-weight-normal m-0">Discount</label>--}}
                                {{--                            <div class="text-large"><strong>$20</strong></div>--}}
                                {{--                        </div>--}}
                                <div class="text-right mt-4">
                                    <label class="text-muted font-weight-normal m-0">قیمت کل</label>
                                    @php
                                        $total = \Cart::all()->sum(function ($cart){
                                        $discount = $cart['discount_percent'] ? $cart['discount_percent'] * $cart['product']->price : 0;
                                        return $cart['quantity'] * ($cart['product']->price - $discount);
                                        });
                                    @endphp
                                    <div class="text-large"><strong>{{ $total }} تومان</strong></div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <form action="{{ route('discount.check') }}" method="post" class="form-inline">
                                    @csrf


                                    <input type="text" class="form-control" name="code">
                                    @error('code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                    <button type="submit"  class="btn btn-lg btn-sm btn-primary mt-2">اعمال تخفیف</button>

                                    <a href="{{ route('discount.delete') }}" class="btn btn-lg btn-sm btn-danger mt-2">حذف تخفیف</a>
                                </form>
                            </div>
                            <div class="col text-left">

                                <a id="payment-button" onclick="hideElement()" href="{{ route('payment.redirect') }}" class="btn btn-sm btn-primary mt-2">پرداخت</a>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        <!-- Shopping cart table -->

    </div>
@endsection

@section('script')
    <script>
        function updateCart(e,id) {
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type' : 'application/json'
                }
            });

            //
            $.ajax({
                type : 'POST',
                url : '/cart/quantity/change',
                data : JSON.stringify({
                    id : id ,
                    quantity : e.target.value,
                    _method : 'patch'
                }),
                success : function(res) {
                    console.log(res);
                    location.reload();
                }
            });
        }

        function hideElement() {
            document.getElementById('payment-button').style.display = 'none';
        }
    </script>

    @endsection
