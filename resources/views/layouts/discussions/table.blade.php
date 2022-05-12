<table class="datatable table mb-3 wrapper-scrollable">
    <thead>
    <tr>
        <th class="text-nowrap"></th>
    </tr>
    </thead>
    <tbody id="nk-ibx-list">
    @foreach ($discussions AS $discussion)
        <tr>
            <td class="p-0 sorting_1">
                <div class="scrollable">
                    <div class="nk-ibx-item {{ $isBackEnd ? 'px-2' : 'px-3' }} {{ !$isBackEnd ? ($discussion->is_read_sender ? '' : 'is-unread') : '' }} {{ $isBackEnd ? ($discussion->is_read_assignee ? '' : 'is-unread') : '' }}">
                        <div class="d-flex w-100">
                            @ifBackEnd
                            <div class="custom-control custom-control-sm custom-checkbox" style="position: relative; top: 1px">
                                <input type="checkbox" class="custom-control-input nk-dt-item-check checkbox-assigned-me" value="{{ $discussion->id }}" id="checkbox-{{ $discussion->id }}">
                                <label class="custom-control-label" for="checkbox-{{ $discussion->id }}"></label>
                            </div>
                            @endIfBackEnd
                            <div class="flex-grow-1 {{ $isBackEnd ? 'ml-2' : '' }}">
                                <a class="{{ $isBackEnd ? 'nk-ibx-link-custom' : 'nk-ibx-link' }}" href="{{ $isBackEnd ? '/admin' : '' }}/discussion/{{ $discussion->id }}"></a>
                                <div class="nk-ibx-context-group">
                                    <div class="text-gray-700">
                                        <em class="icon ni ni-mail{{ !$isBackEnd ? ($discussion->is_read_sender ? '' : '-fill') : (!$discussion->is_read_assignee ? '-fill' : '') }} mr-1 icon-read-mail"></em>
                                        {{--<span class="badge badge-{{ $discussion->is_closed ? 'light' : 'success' }} mr-1 justify-content-center" style="width: 50px">{{ $discussion->is_closed ? 'Closed' : 'Open' }}</span>--}}
                                        <span class="fw-bold">{{ $discussion->subject }}</span> {{ !empty($discussion->vin) ? ' (' . $discussion->vin . ')' : '' }}
                                    </div>
                                </div>
                                <div class="text-truncate" style="max-width: 100%; width: 500px">
                                    {{ $discussion->latestMessage()->message }}
                                </div>
                            </div>

                            <div class="nk-ibx-item-time">
                                <div class="sub-text text-nowrap">{{ $discussion->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="nk-ibx-item-tools">
                                <div class="ibx-actions">
                                    <ul class="ibx-actions-hidden gx-1">
                                        @ifBackEnd
                                        <li>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-icon btn-trigger btn-discussion-toggle-assign" data-id="{{$discussion->id}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ $discussion->assignee == auth()->user()->id ? 'Unassigned from me' : 'Assign to me' }}"><em class="icon ni ni-user-{{ $discussion->assignee == auth()->user()->id ? 'check' : 'cross' }}"></em></a>
                                        </li>
                                        @endIfBackEnd
                                        <li>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-icon btn-trigger btn-discussion-toggle-read" data-id="{{$discussion->id}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mark as {{ !$isBackEnd ? ($discussion->is_read_sender ? 'unread' : 'read') : ($discussion->is_read_assignee ? 'unread' : 'read') }}"><em class="icon ni ni-mail"></em></a>
                                        </li>
                                        @ifFrontEnd
                                        <li class="d-none">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-icon btn-trigger btn-discussion-delete {{ $discussion->messages->count() > 1 ? 'disabled' : '' }}" data-id="{{$discussion->id}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><em class="icon ni ni-trash"></em></a>
                                        </li>
                                        @endIfFrontEnd
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
