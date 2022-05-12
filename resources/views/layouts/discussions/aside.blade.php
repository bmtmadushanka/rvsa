<div class="nk-ibx-aside" data-content="inbox-aside" data-toggle-overlay="true" data-toggle-screen="lg">
    <div class="nk-ibx-nav" data-simplebar>
        <ul class="nk-ibx-menu">
            @foreach ($tab_groups AS $group => $tabs)
                @foreach($tabs AS $tab)
                    <li class="{{ $tab['name'] === $active_tab ? 'active' : '' }}">
                        <a class="nk-ibx-menu-item" href="/admin/discussions/{{ $tab['key'] === 'discussions' ? '' : $tab['key'] }}">
                            <em class="icon ni ni-{{ $tab['icon'] }}"></em>
                            <span class="nk-ibx-menu-text">{{ ucfirst($tab['name']) }}</span>
                            @if (!empty($tab['count']))
                                <span class="badge badge-pill badge-{{ $tab['badge_color'] }}">{{ $tab['count'] }}</span>
                            @endif
                        </a>
                    </li>
                @endforeach
                <hr />
            @endforeach
        </ul>
    </div>
</div>
