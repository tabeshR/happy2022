@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تایید آدرس ایمیل</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            لینک جدید تایید ایمیل به ایمیل شما ارسال شد
                        </div>
                    @endif

                   قبل از ادامه دادن لطفا ایمیل خود را چک کنید ، لینک تایید ایمیل برای شما ارسال شده است ، چنانچه چنین ایمیلی را دریافت نکردید روی دکمه زیر بزنید

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">ارسال مجدد لینک تاییدیه ایمیل</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
