<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Growth - @yield('title', 'Platform')</title>
    <link rel="stylesheet" href="{{ asset('sass/vender/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('sass/vender/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('owlcarousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('owlcarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css">
    <link rel="stylesheet" href="{{ asset('sass/main.css') }}">
    @yield('styles')
</head>

<body>

    <div class="post_page">
        <!--***** nav menu start ****** -->
        <div class="nav_menu">
            <div class="fix_top">
                <!-- nav for big->medium screen -->
                <div class="nav">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img class="d-block d-lg-none small-logo" src="{{ asset('images/instagram.png') }}"
                                alt="logo">
                            <img class="d-none d-lg-block" src="{{ asset('images/logo_menu.png') }}" alt="logo">
                        </a>
                    </div>
                    <div class="menu">
                        <ul>
                            <li>
                                <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                    <img src="{{ asset('images/accueil.png') }}">
                                    <span class="d-none d-lg-block">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}"
                                    href="{{ route('tasks.index') }}">
                                    <img src="{{ asset('images/compass.png') }}">
                                    <span class="d-none d-lg-block">Tasks</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->routeIs('referrals.*') ? 'active' : '' }}"
                                    href="{{ route('referrals.index') }}">
                                    <img src="{{ asset('images/send.png') }}">
                                    <span class="d-none d-lg-block">Referrals</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->routeIs('withdraw.*') ? 'active' : '' }}"
                                    href="{{ route('withdraw.index') }}">
                                    <img src="{{ asset('images/tab.png') }}">
                                    <span class="d-none d-lg-block">Withdraw</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->routeIs('profile') ? 'active' : '' }}"
                                    href="{{ route('profile') }}">
                                    <img class="circle story" src="{{ asset('images/profile_img.jpg') }}">
                                    <span class="d-none d-lg-block">Profile</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="more">
                        <div class="btn-group dropup">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="{{ asset('images/menu.png') }}">
                                <span class="d-none d-lg-block">More</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <span>Balance: {{ Auth::user()->balance_aed ?? 0 }} AED</span>
                                    </a>
                                </li>
                                @if (Auth::user()->isAdmin())
                                    <li style="border-top: 1px solid #dbdbdb; margin-top: 5px; padding-top: 5px;">
                                        <a class="dropdown-item" href="{{ route('admin.submissions.index') }}">
                                            <span>Review Proofs</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.withdrawals.index') }}">
                                            <span>Manage Payouts</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.codes.index') }}">
                                            <span>Access Codes</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.tasks.index') }}">
                                            <span>Manage Tasks</span>
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                        @csrf
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <span>Log out</span>
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- nav for small screen  -->
                <div class="nav_sm">
                    <div class="content">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img class="logo" src="{{ asset('images/logo_menu.png') }}">
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <span>Balance: {{ Auth::user()->balance_aed ?? 0 }} AED</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <span>Log out</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="left">
                            <div class="search_bar">
                                <div class="input-group">
                                    <div class="form-outline">
                                        <div>
                                            <img src="{{ asset('images/search.png') }}" alt="search">
                                        </div>
                                        <input type="text" id="form1" class="form-control"
                                            placeholder="Search" />
                                    </div>
                                </div>
                            </div>
                            <div class="notifications notification_icon">
                                <a href="{{ route('tasks.index') }}">
                                    <img src="{{ asset('images/compass.png') }}">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- nav for ex-small screen  -->
                <div class="nav_xm">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img class="logo" src="{{ asset('images/logo_menu.png') }}">
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <span>Balance: {{ Auth::user()->balance_aed ?? 0 }} AED</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span>Log out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="left">

                        <a href="{{ route('tasks.index') }}">
                            <img src="{{ asset('images/compass.png') }}">
                        </a>
                        <a href="{{ route('referrals.index') }}">
                            <img class="notification_icon" src="{{ asset('images/send.png') }}">
                        </a>
                    </div>
                </div>
            </div>
            <!-- menu in the botton for smal screen  -->
            <div class="nav_bottom">
                <a href="{{ route('home') }}"><img src="{{ asset('images/accueil.png') }}"></a>
                <a href="{{ route('tasks.index') }}"><img src="{{ asset('images/compass.png') }}"></a>
                <a href="{{ route('referrals.index') }}"><img src="{{ asset('images/send.png') }}"></a>
                <a href="{{ route('withdraw.index') }}"><img src="{{ asset('images/tab.png') }}"></a>
                <a href="{{ route('profile') }}"><img class="circle story"
                        src="{{ asset('images/profile_img.jpg') }}"></a>
            </div>
        </div>
        <!--***** nav menu end ****** -->

        <div class="second_container">
            @yield('content')
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('owlcarousel/jquery.min.js') }}"></script>
    <script src="{{ asset('owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('scripts')
</body>

</html>
