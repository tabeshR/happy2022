@extends('admin.layouts.app')
@section('title')
    مدیریت کاربران
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">خانه</a></li>
        <li class="breadcrumb-item active">مدیریت کاربران</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col mb-2">
            <a class="btn btn-sm btn-primary float-left" href="{{ route('admin.users.create') }}">افزودن کاربر جدید</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">جدول کاربران</h3>

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
                            <th>ایمیل</th>
                            <th>موبایل</th>
                            <th>آوتار</th>
                            <th>امنیت</th>
                            <th>تاریخ عضویت</th>
                            <th>نوع کاربری</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    <span
                                        class="text-{{ $user->hasVerifiedEmail() ? "success" : "danger" }}">{{ $user->email }}</span>
                                </td>
                                <td>{{ $user->mobile }}</td>
                                <td>
                                    <img src="{{ $user->avatar }}" alt="آواتار" class="img-circle" width="50px">
                                </td>
                                <td>
                                    <span
                                        class="mr-3 fa fa-{{ $user->two_factor_type == 'off' ? "times text-danger" : "check text-success" }}"></span>
                                </td>
                                <td>{{ jdate($user->created_at)->ago() }}</td>
                                <td>{{ ($user->is_admin || $user->is_staff) ? "مدیر" : "کاربر عادی"}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.users.edit',$user->id) }}" class="btn btn-primary btn-sm">ویرایش</a>
                                        @if(auth()->id() !== $user->id)
                                            <a onclick="event.preventDefault();askForDelete('{{ $user->id }}')" href="#" class="btn btn-danger btn-sm">حذف</a>
                                        @endif
                                    </div>
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy',$user->id) }}" method="post" id="delete-{{ $user->id }}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.card-body -->
            </div>
        {{ $users->appends(['search'=>request('search')])->render() }}
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
