@extends('admin.layouts.app')
@section('title')
    افزودن کاربر جدید
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">خانه</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.users.index') }}">مدیریت کاربران</a>
        </li>
        <li class="breadcrumb-item active"> افزودن کاربر جدید</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">افزودن کاربر جدید</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">نام</label>

                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="inputEmail3" placeholder="نام را وارد کنید" value="{{ old('name') }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ایمیل</label>

                            <div class="col-sm-10">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail3" name="email" placeholder="ایمیل را وارد کنید" value="{{ old('email') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">پسورد</label>

                            <div class="col-sm-10">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="inputPassword3" name="password" placeholder="پسورد را وارد کنید">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">تایید پسورد</label>

                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="inputPassword3" name="password_confirmation" placeholder="پسورد را تکرار کنید">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="isValidMail" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck2">تایید ایمیل</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">مقام های مربوط</label>

                            <div class="row">
                                @foreach($roles as $role)
                                    <div class="col-3">
                                        <label for="{{ $role->id }}">{{ $role->name }}</label>
                                        <input id="{{ $role->id }}" name="roles[]" type="checkbox" value="{{ $role->id }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">دسترسی های مربوط</label>

                            <div class="row mt-1">
                                @foreach($permissions as $permission)
                                    <div class="col-3">
                                        <label for="{{ $permission->id }}">{{ $permission->name }}</label>
                                        <input name="permissions[]" type="checkbox" id="{{ $permission->id }}" value="{{ $permission->id }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت نام</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endsection
