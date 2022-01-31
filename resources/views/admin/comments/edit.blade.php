@extends('admin.layouts.app')
@section('title')
    ویرایش دیدگاه
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">خانه</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.comments.index') }}">مدیریت دیدگاه ها</a>
        </li>
        <li class="breadcrumb-item active"> ویرایش دیدگاه</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">ویرایش دیدگاه </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" action="{{ route('admin.comments.update',$comment->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">دیدگاه</label>

                            <div class="col-sm-10">
                                <textarea cols="5"  name="comment" class="form-control @error('comment') is-invalid @enderror"
                                            id="inputEmail3" placeholder="دیدگاه را وارد کنید">{{ old('comment',$comment->comment) }}</textarea>
                                @error('comment')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirmed">تایید دیدگاه</label>
                            <input id="confirmed"
                                   {{ $comment->confirmed == 1 ? "checked" : "" }}
                                   type="checkbox" name="confirmed">
                        </div>

                        @foreach($comment->child as $child)
                           <div class="form-group">
                                <textarea cols="5"  name="comment" class="form-control"
                                          id="inputEmail3" placeholder="دیدگاه را وارد کنید">{{ ($child->comment) }}</textarea>

                           </div>
                        @endforeach

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">پاسخ</label>

                            <div class="col-sm-10">
                                <textarea cols="5"  name="reply" class="form-control @error('reply') is-invalid @enderror"
                                            id="inputEmail3" placeholder="دیدگاه را وارد کنید">{{ old('reply') }}</textarea>
                                @error('reply')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش دیدگاه</button>
                        <a href="{{ route('admin.comments.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endsection
