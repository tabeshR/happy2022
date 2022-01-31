<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">خانه</a>
        </li>
        @if(auth()->check())
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('profile') }}" class="nav-link">پروفایل</a>
            </li>
            @endif

        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">محصولات</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">دسته بندی ها</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">عکس ها</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('cart') }}" class="nav-link">
                سبد خرید
                <span class="badge badge-danger">{{ \Cart::count() }}</span>
            </a>
        </li>
    </ul>

    <!-- SEARCH FORM -->


    <!-- Right navbar links -->

   @if(auth()->check())
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">

                <div class="" aria-labelledby="">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        خروج
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>

       @endif


</nav>
