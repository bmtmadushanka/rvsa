@auth
    <ul class="nk-menu nk-menu-main ui-s2">
        <li class="nk-menu-item">
            <a href="{{ route('web_dashboard') }}" class="nk-menu-link">
                <span class="nk-menu-text">Dashboard</span>
            </a>
        </li>
        <li class="nk-menu-item">
            <a href="{{ route('web_reports') }}" class="nk-menu-link">
                <span class="nk-menu-text">Model Reports</span>
            </a>
        </li>
        <li class="nk-menu-item has-sub">
            <a href="#" class="nk-menu-link nk-menu-toggle">
                <span class="nk-menu-text">My Account</span>
            </a>
            <ul class="nk-menu-sub">
                <li class="nk-menu-item">
                    <a href="{{ route('web_user_profile') }}" class="nk-menu-link"><span class="nk-menu-text">My Profile</span></a>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('web_user_reports') }}" class="nk-menu-link"><span class="nk-menu-text">My Model Reports</span></a>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('web_user_orders') }}" class="nk-menu-link"><span class="nk-menu-text">My Orders</span></a>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('web_user_notifications', 'updates') }}" class="nk-menu-link"><span class="nk-menu-text">My Notifications</span></a>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('web_user_discussions') }}" class="nk-menu-link"><span class="nk-menu-text">My Discussions</span></a>
                </li>
            </ul>
        </li>
    </ul>
@endauth
