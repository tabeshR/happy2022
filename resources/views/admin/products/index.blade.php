@extends('admin.layouts.app')
@section('title')
    مدیریت محصولات
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">خانه</a></li>
        <li class="breadcrumb-item active">مدیریت محصولات</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col mb-2">
            <a class="btn btn-sm btn-primary float-left" href="{{ route('admin.products.create') }}">افزودن محصول جدید</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">جدول محصولات</h3>

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
                            <th>توضیحات</th>
                            <th>عکس</th>
                            <th>قیمت</th>
                            <th>موجودی</th>
                            <th>تاریخ ثبت</th>
                            <th>تعداد بازدید</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                        {{ \Str::limit($product->description,10) }}
                                </td>
                                <td>
                                    <img src="{{ asset('img/'.$product->img) }}" alt="آواتار" class="img-circle" width="50px" height="50px">
                                </td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->inventory }}</td>
                                <td>{{ jdate($product->created_at)->ago() }}</td>
                                <td>{{ $product->view_count }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.products.edit',$product->id) }}" class="btn btn-primary btn-sm">ویرایش</a>
                                            <a onclick="event.preventDefault();askForDelete('{{ $product->id }}')" href="#" class="btn btn-danger btn-sm">حذف</a>
                                    </div>

                                        <form action="{{ route('admin.products.destroy',$product->id) }}" method="post" id="delete-{{ $product->id }}">
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
        {{ $products->appends(['search'=>request('search')])->render() }}
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
