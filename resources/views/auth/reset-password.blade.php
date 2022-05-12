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
                                    <h4 class="nk-block-title">Reset Password</h4>
                                </div>
                                <div class="alert alert-gray alert-icon mb-4 px-3">
                                    We've sent a verification code to your mobile number (+61){{ $_GET['mobile_no'] }}.
                                </div>
                                <form class="form" method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    @include('layouts.messages')
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label required" for="default-code">Code</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="default-code" name="code" placeholder="Enter the verification code" value="{{ old('code') }}" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label required" for="password">New Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" tabindex="-1" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label required" for="input-confirm-password">Confirm Password</label>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control form-control-lg" id="input-confirm-password" name="password_confirmation" required autocomplete="off" placeholder="Re-Enter Password">
                                        </div>
                                    </div>
                                    <div class="form-group mt-4">
                                        <button class="btn btn-lg btn-primary btn-block">Update Password</button>
                                        <input type="hidden" name="mobile_no" value="{{ $_GET['mobile_no'] }}" />
                                    </div>
                                </form>
                                <div class="form-note-s2 text-center pt-4">
                                    <a href="{{ route('login') }}"><strong>Return to login</strong></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
