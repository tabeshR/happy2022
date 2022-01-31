@extends('layouts.app')

@section('sidebar')
    @include('layouts.sidebar')
@endsection


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

@section('title')
    پروفایل
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><a href="{{ route('profile') }}">پروفایل</a></li>
        <li class="breadcrumb-item">تنظیمات احراز هویت دو مرحله ای</li>
    </ol>
    @endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">تنظیمات احراز هویت دومرحله ای</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="post" action="{{ route('2fa.settings') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">وضعیت</label>

                                <div class="col-sm-10">
                                    <select name="type" id="" class="form-control @error('type') is-invalid @enderror">
                                        @foreach(config('TwoFactorTypes') as $key => $val)
                                            <option
                                                {{ $key == auth()->user()->two_factor_type ? "selected" : "" }}
                                                value="{{ $key }}">{{ $val }}</option>
                                            @endforeach
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">شماره موبایل</label>

                                <div class="col-sm-10">
                                    <input name="mobile" type="tel" class="form-control @error('mobile') is-invalid @enderror" id="inputPassword3" value="{{ old('mobile',auth()->user()->mobile) }}">
                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">ارسال</button>
                            <a href="{{ route('profile') }}" class="btn btn-default float-left">لغو</a>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection
