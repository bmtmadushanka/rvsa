@unless ($tab_data->isEmpty())
    <table class="datatable table mb-3 wrapper-scrollable">
        <thead>
        <tr>
            <th class="text-nowrap"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="p-0 border-bottom">
                <div class="nk-ibx-item p-0">
                    <div class="nk-ibx-item-elem nk-ibx-item-user flex-grow-1">
                        <div id="accordion" class="accordion border-0">
                            @foreach ($tab_data AS $activity)
                            <div class="accordion-item">
                                <a href="#" class="accordion-head" data-toggle="collapse" data-target="#accordion-item-{{ $activity->id }}" style="color: initial; {{ $activity->description ? '' : 'cursor: initial' }}">
                                    <span><em class="mr-1 icon ni ni-{{ $activity->heading['icon'] }}"></em> {{ $activity->heading['title'] }} at {{ date('Y-M-d G:i:s A', strtotime($activity->created_at)) }}</span>
                                    @if ($activity->description)
                                    <span class="accordion-icon"></span>
                                    @endif
                                </a>
                                @if ($activity->description)
                                <div class="accordion-body collapse" id="accordion-item-{{ $activity->id }}" data-parent="#accordion">
                                    <div class="accordion-inner">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
@else
    <div class="nk-ibx-item p-5 nk-ibx-item-fluid justify-content-center fs-17px">
        <div style="position: absolute; top: 100px"><em class="icon ni ni-info mr-1"></em> You haven't purchased any report yet!</div>
    </div>
@endunless
