@extends('admin.layouts.app')
@section('title')
    ویرایش محصول
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">خانه</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.products.index') }}">مدیریت محصولات</a>
        </li>
        <li class="breadcrumb-item active"> ویرایش محصول</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">ویرایش محصول </h3>
                </div>
                <div id="allAttributes" data-attributes="{{ json_encode(\App\Models\Attribute::all()->pluck('name')) }}"></div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" action="{{ route('admin.products.update',$product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="card-body">
                        @if($product->img)
                            <a href="{{ asset('img/'.$product->img) }}">
                                <img src="{{ asset('img/'.$product->img) }}" alt=""
                                     style="width: 100px;margin: 10px auto;display: block" class="img-circle">
                            </a>
                        @endif
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">تصویر شاخص</label>

                            <div class="col-sm-10">
                                <input type="file" name="img" class="form-control @error('img') is-invalid @enderror"
                                       id="inputEmail3" placeholder="عکس را وارد کنید" value="{{ old('img',$product->img) }}">
                                @error('img')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">نام</label>

                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       id="inputEmail3" placeholder="نام را وارد کنید" value="{{ old('name',$product->name) }}">
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
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="inputEmail3" name="description"
                                          placeholder="توضیحات را وارد کنید">{{ old('description',$product->description) }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">قیمت</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('price') is-invalid @enderror"
                                       id="inputPassword3" name="price" placeholder="قیمت را وارد کنید" value="{{ old('price',$product->price) }}">
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">موجودی</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('inventory') is-invalid @enderror"
                                       id="inputPassword3" name="inventory" placeholder="موجودی را وارد کنید" value="{{ old('inventory',$product->inventory) }}">
                                @error('inventory')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-10 control-label">ویژگی ها
                                    <button onclick="event.preventDefault();makeNewAttr()"
                                            class="btn btn-danger btn-sm float-left">افزودن ویژگی جدید
                                    </button>
                                </label>
                                <div class="col-sm-10 mt-2" id="attributes">
                                    @foreach($product->attributes as $attribute)
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="">نام</label>
                                                <select type="text" class="form-control attribute-select" onchange="changeAttributeValues(event,{{ $loop->index }})" name='attribute[{{ $loop->index }}][name]'>
                                                    <option value="0">انتخاب کنید</option>
                                                    @foreach(App\Models\Attribute::all() as $attr)

                                                        <option value="{{ $attr->name }}"
                                                        {{ $attribute->id == $attr->id ? "selected" : "" }}
                                                        >{{ $attr->name }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label for="">مقدار</label>
                                                <select type="text" class="form-control attribute-select" name="attribute[{{ $loop->index }}][value]">
                                                    <option value="0">انتخاب کنید</option>
                                                    @foreach($attribute->values as $value)

                                                        <option value="{{ $value->value }}"
                                                        {{ $value->id == $attribute->pivot->value_id ?"selected" : "" }}
                                                        >{{ $value->value }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    @endforeach


                                </div>
                            </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش محصول</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.attribute-select').select2({ tags : true });
        });

        function makeNewAttr() {
            let id = document.getElementById('attributes').children.length;
            let attributes = $('#attributes');
            let allAttributes = $('#allAttributes').data('attributes');
            attributes.append(createAttributeItem((id + 1),allAttributes));
            $('.attribute-select').select2({ tags : true });
        }

        function createAttributeItem(id,allAttributes) {
            return `<div class="row mb-3">
                                    <div class="col">
                                        <label for="">نام</label>
                                        <select type="text" class="form-control attribute-select" onchange="changeAttributeValues(event,${id})" name='attribute[${id}][name]'>
<option value="0">انتخاب کنید</option>
${allAttributes.map((attr)=>{
                return `<option value="${attr}">${attr}</option>`
            })}
</select>
                                    </div>
                                    <div class="col">
                                        <label for="">مقدار</label>
                                        <select type="text" class="form-control attribute-select" name="attribute[${id}][value]">

</select>
                                    </div>
                                </div>`
        }


        let changeAttributeValues = (event , id) => {
            let valueBox = $(`select[name='attribute[${id}][value]']`);
            console.log(id);

            //
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type' : 'application/json'
                }
            });
            //
            $.ajax({
                type : 'POST',
                url : '/admin/attribute/values',
                data : JSON.stringify({
                    name : event.target.value
                }),
                success : function(res) {
                    valueBox.html(`
                            <option value="" selected>انتخاب کنید</option>
                            ${
                        res.data.map(function (item) {
                            return `<option value="${item}">${item}</option>`
                        })
                    }
                        `);
                }
            });
        }
    </script>

@endsection
