@extends('layouts.app')

@section('content')
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    @endif
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col mb-2">

                        <a href="#"
                           class="float-left btn btn-danger btn-sm">
                            <i class="fa fa-shopping-cart
"></i>
                            خرید
                        </a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <a href="{{ asset('img/'.$product->img) }}">
                                    <img src="{{ asset('img/'.$product->img) }}" alt="" class="img-circle"
                                         style="width: 400px;margin: 0 auto;display: block">
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
                            <div class="col my-3 text-center text-justify">
                                {{ $product->description }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                موجودی :
                                {{ $product->inventory }}
                                عدد
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col">
                                <h5>ویژگی ها</h5>
                                @php
                                    $new = [];
                                    foreach ($product->attributes as $elem) {
                                        $new[$elem['name']]['name'] = $elem['name'];
                                        $new[$elem['name']]['value'][] = $elem->pivot->value->value;
                                    }

                                    $productAttributes = array_values($new);
                                @endphp
                                <ul style="list-style: none">
                                    @foreach($productAttributes as $productAttribute)
                                        <li>
                                            <span>{{ $productAttribute['name'] }} : </span>
                                            <span>

                                                    @foreach($productAttribute['value'] as $value)
                                                   {{ $value }} {{ !$loop->last ? "," : "" }}
                                                   @endforeach

                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col mt-3">
                <div class="row">
                    <div class="col mb-2">
                        <h4 class="float-right">دیدگاه ها</h4>
                        <a href="#" data-toggle="modal" data-target="#exampleModal"
                           class="btn btn-sm btn-primary float-left"
                           onclick="event.preventDefault();changeParentId(null)">ارسال دیدگاه</a>
                    </div>
                </div>
                @if($product->comments()->where('confirmed',1)->count() == 0)
                    <div class="alert alert-info">
                        تاکنون دیدگاهی درباره این محصول ثبت نشده است
                    </div>
                @else
                    @foreach($product->comments()->where('parent_id',null)->where('confirmed',1)->get() as $comment)
                        <div class="card">
                            <div class="card-header">
                                <span class="float-right">  {{ $comment->user->name }}</span>
                                <span class="float-left">
                                                   <span
                                                       class="ml-3 text-muted"> {{ jdate($comment->created_at)->ago() }}</span>
                              <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#exampleModal"
                                 onclick="event.preventDefault();changeParentId('{{ $comment->id }}')">پاسخ</a>
                              </span>
                            </div>
                            <div class="card-body">
                                {{ $comment->comment }}
                                <div class="mb-3"></div>
                                @if($comment->child()->where('confirmed',1)->count())
                                    @include('comments.layout',['comments'=>$comment->child()->where('confirmed',1)->get(),'parent_id'=>$comment->id])
                                @endif

                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{--    modal   --}}
    <!-- Modal -->
   <x-comment :route="route('comment.send')" :subjectId="$product->id" :subjectType="$product" />
    {{--  end modal  --}}
@endsection
@section('script')
    <script>
        function changeParentId(id) {
            document.getElementById('parent_id').value = id;
        }
    </script>
@endsection
