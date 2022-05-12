@if (auth()->user() && !auth()->user()->is_verified && Route::currentRouteName() !== 'verify_mobile.prompt')
    <a href="{{ route('verify_mobile.prompt') }}">
        <div class="alert alert-danger alert-icon text-center pt-2 pb-3">
            <em class="icon ni ni-info" style="position: relative; top:3px; left: 0px"></em> Your mobile number is not verified yet. Click here to verify your mobile.
        </div>
    </a>
@endif

<!-- main header @s -->
<div class="nk-header nk-header-fluid is-theme">
    <div class="container-xl wide-xl">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger mr-sm-2 d-lg-none">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand p-1">
                <a href="/" class="logo-link">
                    <img class="logo-light logo-img" src="{{ config('app.asset_url') }}images/logos/{{ Company::get('logo') }}" alt="Logo" style="width: auto; height: 55px; max-height: 55px">
                </a>
            </div><!-- .nk-header-brand -->
            <div class="nk-header-menu" data-content="headerNav">
                <div class="nk-header-mobile">
                    <div class="nk-header-brand">
                        <a href="/dashboard" class="logo-link">
                            <img class="logo-dark logo-img" src="{{ config('app.asset_url') }}images/logos/{{ Company::get('logo') }}" alt="Logo" style="width: 130px; height: 40px">
                        </a>
                    </div>
                    <div class="nk-menu-trigger mr-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                    </div>
                </div>
                @ifBackEnd
                    @include('layouts.admin.nav_links')
                @notBackEnd
                    @include('layouts.web.nav_links')
                @endIfBackEnd
            </div><!-- .nk-header-menu -->
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    @auth
                        @if (!$isBackEnd && empty($hideMiniCart))
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-toggle="dropdown">
                                    <div class="icon-status icon-status-info"><em class="icon ni ni-cart"></em></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right dropdown-menu-s1">
                                    <div class="dropdown-head">
                                        <span class="sub-title nk-dropdown-title">Mini Cart</span>
                                        <a href="#">Clear Cart</a>

                                    </div>
                                    <div class="dropdown-body">
                                        <div class="nk-notification" id="mini-cart"></div>
                                    </div><!-- .nk-dropdown-body -->
                                    <div class="dropdown-foot center">
                                        <a href="/cart">View Cart</a>
                                    </div>
                                </div>
                            </li>
                        @endif
                        <li class="dropdown notification-dropdown d-none">
                            <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-toggle="dropdown">
                                <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right dropdown-menu-s1">
                                <div class="dropdown-head">
                                    <span class="sub-title nk-dropdown-title">Notifications</span>
                                    <a href="#">Mark All as Read</a>
                                </div>
                                <div class="dropdown-body">
                                    <div class="nk-notification">
                                        <div class="nk-notification-item dropdown-inner">
                                            <div class="nk-notification-icon">
                                                <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                            </div>
                                            <div class="nk-notification-content">
                                                <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                <div class="nk-notification-time">2 hrs ago</div>
                                            </div>
                                        </div>
                                        <div class="nk-notification-item dropdown-inner">
                                            <div class="nk-notification-icon">
                                                <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                            </div>
                                            <div class="nk-notification-content">
                                                <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                                <div class="nk-notification-time">2 hrs ago</div>
                                            </div>
                                        </div>
                                        <div class="nk-notification-item dropdown-inner">
                                            <div class="nk-notification-icon">
                                                <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                            </div>
                                            <div class="nk-notification-content">
                                                <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                <div class="nk-notification-time">2 hrs ago</div>
                                            </div>
                                        </div>
                                        <div class="nk-notification-item dropdown-inner">
                                            <div class="nk-notification-icon">
                                                <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                            </div>
                                            <div class="nk-notification-content">
                                                <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                                <div class="nk-notification-time">2 hrs ago</div>
                                            </div>
                                        </div>
                                        <div class="nk-notification-item dropdown-inner">
                                            <div class="nk-notification-icon">
                                                <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                            </div>
                                            <div class="nk-notification-content">
                                                <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                <div class="nk-notification-time">2 hrs ago</div>
                                            </div>
                                        </div>
                                        <div class="nk-notification-item dropdown-inner">
                                            <div class="nk-notification-icon">
                                                <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                            </div>
                                            <div class="nk-notification-content">
                                                <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                                <div class="nk-notification-time">2 hrs ago</div>
                                            </div>
                                        </div>
                                    </div><!-- .nk-notification -->
                                </div><!-- .nk-dropdown-body -->
                                <div class="dropdown-foot center">
                                    <a href="#">View All</a>
                                </div>
                            </div>
                        </li><!-- .dropdown -->
                        <li class="dropdown user-dropdown order-sm-first">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <div class="user-toggle">
                                    <div class="user-avatar sm">
                                        <em class="icon ni ni-user-alt"></em>
                                    </div>
                                    <div class="user-info d-none d-xl-block">
                                        @if (auth()->user()->is_admin)
                                            <div class="user-status">Administrator</div>
                                        @endif
                                        <div class="user-name dropdown-indicator">
                                            {{ auth()->user()->is_admin ? (auth()->user()->first_name . ' '. auth()->user()->last_name)  : auth()->user()->client->raw_company_name }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1 is-light">
                                <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                    <div class="user-card">
                                        <div class="user-avatar">
                                            <span>{{ auth()->user()->acronym }}</span>
                                        </div>
                                        <div class="user-info">
                                            {{--<span class="lead-text">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>--}}
                                            <span class="lead-text">{{ auth()->user()->is_admin ? Company::get('default_raw_company_name') : auth()->user()->client->raw_company_name }}</span>
                                            <span class="sub-text">{{ auth()->user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="dropdown-inner user-account-info">
                                    <h6 class="overline-title-alt">Account Balance</h6>
                                    <div class="user-balance">1,494.23 <small class="currency currency-usd">USD</small></div>
                                    <div class="user-balance-sub">Locked <span>15,495.39 <span class="currency currency-usd">USD</span></span></div>
                                    <a href="#" class="link"><span>Withdraw Balance</span> <em class="icon ni ni-wallet-out"></em></a>
                                </div>
                                <div class="dropdown-inner">
                                    <ul class="link-list">
                                        <li><a href="html/user-profile-regular.html"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                        <li><a href="html/user-profile-setting.html"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                        <li><a href="html/user-profile-activity.html"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li>
                                        <li><a class="dark-mode-switch" href="#"><em class="icon ni ni-moon"></em><span>Dark Mode</span></a></li>
                                    </ul>
                                </div>--}}
                                <div class="dropdown-inner">
                                    <ul class="link-list">
                                        <li><a href="{{ route('logout') }}"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item-auth"><a href="/login">Login</a></li>
                        <li class="nav-item-auth ml-3"><a href="/register">Register</a></li>
                    @endguest
                </ul><!-- .nk-quick-nav -->
            </div><!-- .nk-header-tools -->
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>
<!-- main header @e -->
