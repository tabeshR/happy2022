@extends('layouts.app')

@section('style')
    <style>
        @media (min-width: 768px) {
            .content-wrapper, .main-footer, .main-header {
                transition: margin-right .3s ease-in-out;
                margin-right: 250px;
                margin-left : 0;
                z-index: 3000;
            }
        }
    </style>

    @endsection


@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('title')
    پروفایل
@endsection
{{--@section('breadcrumb')--}}
{{--    <ol class="breadcrumb float-sm-left">--}}
{{--        <li class="breadcrumb-item"><a href="#">پروفایل</a></li>--}}
{{--        <li class="breadcrumb-item active">داشبورد ورژن 2</li>--}}
{{--    </ol>--}}
{{--    @endsection--}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">

            </div>
        </div>

    </div>

@endsection
