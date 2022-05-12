@unless ($tab_data->isEmpty())
    <table class="datatable table mb-3">
        <thead>
        <tr>
            <th class="text-nowrap"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tab_data AS $approval)
        <tr>
            <td class="p-0">
                <div class="nk-ibx-item {{ $isBackEnd && !$approval->is_approved && !$approval->is_read_admin ? 'is-unread' : '' }} {{ !$isBackEnd && !is_null($approval->reviewed_at) && !$approval->is_read_user ? 'is-unread' : '' }}">
                    <div class="nk-ibx-item-elem nk-ibx-item-user flex-grow-1">
                        <a class="nk-ibx-link" href="{{ $isBackEnd ? '/admin/' : '/user/notifications/' }}approval/{{ $approval->id }}"></a>
                        @ifFrontEnd
                        <span class="badge badge-outline-{{ $approval->status['badge_color'] }} mr-1 justify-content-center" style="width: 60px">{{ $approval->status['badge_text'] }}</span>
                        {{ $approval->status['text'] }}
                        @endIfFrontEnd
                        @ifBackEnd
                            @if (is_null($approval->reviewed_at))
                            <span class="badge badge-outline-secondary mr-1 justify-content-center" style="width: 60px">Pending</span>
                            {{ $approval->creator->client->raw_company_name }} has changed it's profile details.
                            @else
                            <span class="badge badge-outline-{{ $approval->is_approved ? 'success' : 'danger' }} mr-1 justify-content-center" style="width: 60px">{{ $approval->is_approved ? 'Approved' : 'Rejected' }}</span>
                            The changes of {{ $isBackEnd ? $approval->creator->client->raw_company_name . '\'s' : 'your' }} profile have been {{ $approval->is_approved ? 'approved' : 'rejected' }}
                            @endif
                        @endIfBackEnd
                    </div>
                    @ifBackEnd
                    <div class="nk-ibx-item-elem nk-ibx-item-time text-nowrap">
                        <div class="sub-text">
                            {{ $approval->reviewed_at ? $approval->reviewed_at->diffForHumans() : $approval->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @endIfBackEnd
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="nk-ibx-item p-5 nk-ibx-item-fluid justify-content-center fs-17px">
        <div style="position: absolute; top: 100px"><em class="icon ni ni-info mr-1"></em> There are no pending approvals</div>
    </div>
@endunless
