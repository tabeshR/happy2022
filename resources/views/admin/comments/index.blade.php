@extends('admin.layouts.app')
@section('title')
    مدیریت نظرات
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">خانه</a></li>
        <li class="breadcrumb-item active">مدیریت نظرات</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">جدول نظرات</h3>

                    <div class="card-tools">
                      <form method="get" action="#">
                          <div class="input-group input-group-sm" style="width: 150px;">
                              <input type="text" name="search" class="form-control float-right" value="{{ request('search') }}" placeholder="جستجو">

                              <div class="input-group-append">
                                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                              </div>
                          </div>
                      </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>آیدی</th>
                            <th>نام</th>
                            <th>نظر</th>
                            <th>تاریخ ثبت</th>
                            <th>دسته</th>
                            <th>درباره</th>
                        </tr>
                        @foreach($comments as $comment)
                            @php
                                $model = explode('App\\Models\\',$comment->commentable_type)[1];
                            @endphp
                            <tr>
                                <td>{{ $comment->id }}</td>
                                <td>{{ $comment->user->name }}</td>
                                <td>
                                        {{ \Str::limit($comment->comment,10) }}
                                </td>
                                <td>{{ jdate($comment->created_at)->ago() }}</td>
                                <td>{{ $model}}</td>
                                <td>{{ $comment->commentable->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.comments.edit',$comment->id) }}" class="btn btn-primary btn-sm">ویرایش</a>
                                            <a onclick="event.preventDefault();askForDelete('{{ $comment->id }}')" href="#" class="btn btn-danger btn-sm">حذف</a>
                                    </div>

                                        <form action="{{ route('admin.comments.destroy',$comment->id) }}" method="post" id="delete-{{ $comment->id }}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.card-body -->
            </div>
        {{ $comments->appends(['search'=>request('search')])->render() }}
            <!-- /.card -->
        </div>




    </div>
@endsection
@section('script')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-left',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast'
            },
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        function askForDelete(id) {
            Swal.fire({
                title: '',
                text: "آیا از حذف این کاربر اطمینان دارید ؟",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'حذف کن',
                cancelButtonText:"لغو عملیات"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-'+id).submit();
                    Toast.fire({
                        icon: 'success',
                        title: 'کاربر با موفقیت حذف شد'
                    })
                }
            })
        }
    </script>

    @endsection
