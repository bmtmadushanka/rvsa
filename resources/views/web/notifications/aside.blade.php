<div class="nk-ibx-aside" data-content="inbox-aside" data-toggle-overlay="true" data-toggle-screen="lg">
    <div class="nk-ibx-nav" data-simplebar>
        <ul class="nk-ibx-menu">
            @foreach ($tab_groups AS $group => $tabs)
                @foreach($tabs AS $tab)
                <li class="{{ $tab['name'] === $active_tab ? 'active' : '' }}">
                    <a class="nk-ibx-menu-item" href="{{ $isBackEnd ? ('client/' . $user->id . '?tab=' . $tab['name']) : route('web_user_notifications', $tab['name']) }}">
                        <em class="icon ni ni-{{ $tab['icon'] }}"></em>
                        <span class="nk-ibx-menu-text">
                            @if (in_array($tab['name'], ['updates', 'account']))
                               {{ $tab['name'] === 'updates' ? 'Version' : 'Profile' }} Changes
                            @else
                            {{ ucfirst($tab['name']) }}
                            @endif
                        </span>
                        @if (!empty($tab['unread_count']))
                        <span class="badge badge-pill badge-{{ $tab['badge_color'] }}">{{ $tab['unread_count'] }}</span>
                        @endif
                    </a>
                </li>
                @endforeach
                <hr />
            @endforeach
        </ul>
    </div>
</div>
