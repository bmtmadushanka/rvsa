@extends('layouts.master')
@section('content')
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-block mt-5 pt-5 nk-auth-body wide-xs">
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="brand-logo pb-4 text-center">
                                    <h4 class="nk-block-title">Verify you Mobile No.</h4>
                                </div>
                                <form class="form" method="POST" action="{{ route('verify_mobile.verify') }}">
                                    @csrf
                                    @include('layouts.messages')
                                    <p>Please enter the verification code that we sent to your mobile number (+61){{ $mobile }}</p>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label required" for="input-code">Code</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="input-code" name="code" placeholder="Enter your verification code" maxlength="50" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block">Verify</button>
                                        <input type="hidden" name="mobile_no" value="{{ $mobile }}" />
                                    </div>
                                </form>
                                {{--<div class="form-note-s2 text-center pt-4">
                                    <a class="pr-2 border-right" href="/user/profile"><strong>Change Number</strong></a>
                                    <a class="pl-2" href="/"><strong>Verify Later</strong></a>
                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
