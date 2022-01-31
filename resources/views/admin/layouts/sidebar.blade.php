<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ auth()->user()->avatar }}"
                         class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item has-treeview {{ isActiveOrOpen(['admin.users.index','admin.users.create'],'menu-open') }}">
                        <a href="#" class="nav-link {{ isActiveOrOpen(['admin.users.index','admin.users.create']) }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                              مدیریت کاربران
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link {{ isActiveOrOpen(['admin.users.index']) }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست کاربران</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.create') }}" class="nav-link {{ isActiveOrOpen(['admin.users.create']) }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن کاربر</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ isActiveOrOpen(['admin.permissions.index','admin.permissions.create'],'menu-open') }}">
                        <a href="#" class="nav-link {{ isActiveOrOpen(['admin.permissions.index','admin.permissions.create']) }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                مدیریت دسترسی ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ isActiveOrOpen(['admin.permissions.index']) }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست دسترسی ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.create') }}" class="nav-link {{ isActiveOrOpen(['admin.permissions.create']) }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن دسترسی</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ isActiveOrOpen(['admin.roles.index','admin.roles.create'],'menu-open') }}">
                        <a href="#" class="nav-link {{ isActiveOrOpen(['admin.roles.index','admin.roles.create']) }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                مدیریت مقام ها
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" class="nav-link {{ isActiveOrOpen(['admin.roles.index']) }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست مقام ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.create') }}" class="nav-link {{ isActiveOrOpen(['admin.roles.create']) }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن مقام</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ isActiveOrOpen(['admin.products.index','admin.products.create'],'menu-open') }}">
                        <a href="#" class="nav-link {{ isActiveOrOpen(['admin.products.index','admin.products.create']) }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                مدیریت محصولات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.products.index') }}" class="nav-link {{ isActiveOrOpen(['admin.users.index']) }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>لیست محصولات</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.products.create') }}" class="nav-link {{ isActiveOrOpen(['admin.products.create']) }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>افزودن محصول</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item has-treeview {{ isActiveOrOpen(['admin.comments.index'],'menu-open') }}">
                        <a href="#" class="nav-link {{ isActiveOrOpen(['admin.comments.index']) }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                مدیریت نظرات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.comments.index',['confirmed'=>1]) }}" class="nav-link {{ isActiveOrOpen(['admin.comments.index']) }}">
                                    <i class="nav-icon fa fa-circle-o text-success"></i>
                                    <p>نظرات تایید شده</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.comments.index',['confirmed'=>0]) }}" class="nav-link {{ isActiveOrOpen(['admin.comments.index']) }}">
                                    <i class="nav-icon fa fa-circle-o text-danger"></i>
                                    <p>نظرات تایید نشده</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
