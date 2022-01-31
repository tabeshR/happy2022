@extends('admin.layouts.app')
@section('title')
    افزودن دسترسی جدید
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">خانه</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.permissions.index') }}">مدیریت دسترسی ها</a>
        </li>
        <li class="breadcrumb-item active"> افزودن دسترسی جدید</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">افزودن دسترسی جدید</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" action="{{ route('admin.permissions.store') }}">
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
                            <label for="inputEmail3" class="col-sm-2 control-label">توضیحات</label>

                            <div class="col-sm-10">
                                <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" id="inputEmail3" placeholder="توضیحات را وارد کنید" value="{{ old('label') }}">
                                @error('label')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت دسترسی</button>
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endsection
