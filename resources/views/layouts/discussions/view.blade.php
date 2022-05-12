@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="{{ $isBackEnd ? '/admin' : '' }}/discussions"><em class="icon ni ni-arrow-left"></em><span>Discussions</span></a></div>
                <div class="d-flex">
                    <h2 class="nk-block-title fw-normal mb-0">Discussion {{ !empty($ticket->vin) ? '-' . $ticket->vin : '' }}</h2>
                </div>

                <h2 class="nk-block-title fw-normal"></h2>
            </div>
        </div>
        @include('layouts.messages')
        <div class="bg-white px-2 pt-3 pb-4">
            <div class="pb-3 px-4 pt-1 border-bottom">
                <h4>{{ $ticket->subject }}</h4>
            </div>
            <div class="d-flex border-bottom px-3 py-5">
                <div class="nk-reply-avatar user-avatar bg-blue">
                    <span>{{ $user->acronym }}</span>
                </div>
                <div class="nk-reply-info w-100">
                    <div class="nk-reply-author lead-text">{{ $user->first_name }} {{ $user->last_name }}</div>
                    <div class="card card-bordered mt-1 w-100">
                        <div class="card-body pb-0">
                            <form class="form" method="POST" action="discussion/{{ $ticket->id }}" enctype="multipart/form-data">
                                @csrf
                                <div class="nk-reply-form-editor">
                                    <div class="form-group">
                                        <div class="nk-reply-form-field border-bottom-0">
                                            <textarea class="form-control form-control-simple" name="message" required maxlength="6000" placeholder="Type your message here">{{ old('message') ?? '' }}</textarea>
                                        </div>
                                        <div class="feedback"></div>
                                    </div>
                                </div>
                                <div class="nk-reply-form-tools py-2">
                                    <div class="form-group my-3">
                                        <div class="form-control-wrap" style="width: 400px;">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="file" id="customFile" accept="image/jpg,image/jpeg,image/gif,image/png,image/x-eps,application/pdf">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-reply-form-tools py-2">
                                    <button class="btn btn-primary" type="submit">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($ticket->messages()->latest()->get() AS $message)
                <div class="d-flex p-3 mt-3 w-100">
                    <div class="nk-reply-avatar user-avatar bg-blue">
                        <span>{{ $message->user->acronym }}</span>
                    </div>
                    <div class="nk-reply-info w-100" style="overflow-wrap: break-word">
                        <div class="nk-reply-author lead-text">{{ $message->user->first_name }} {{ $message->user->last_name }} <span class="ml-3 small text-muted">{{ $message->created_at->diffForHumans() }}</span></div>
                        <div class="mt-1">{!! nl2br($message->message) !!}</div>
                        @if ($message->file)
                            <div class="border p-2 mt-3 mb-2" style="width: 400px;">
                                <a href="/uploads/files/discussions/{{ $message->ticket->id }}/{{ $message->file }}" download>
                                    <em class="icon ni ni-file-img" style="font-size: 35px"></em>
                                    <span style="position: relative; bottom: 10px">{{ $message->file }}</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
