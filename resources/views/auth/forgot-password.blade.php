@extends('layouts.master')
@section('content')
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="nk-block mt-5 pt-5 nk-auth-body wide-xs">
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Reset password</h5>
                                        <div class="nk-block-des">
                                            <p>Please enter the mobile number that you entered when registering with us. We'll send you an authorization code.</p>
                                        </div>
                                    </div>
                                </div>
                                <form method="get" action="{{ route('password.verify') }}">
                                    @csrf
                                    @include('layouts.messages')
                                    <div class="form-group">
                                        <label class="form-label" for="mobile">Mobile</label>
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">+61</span>
                                                </div>
                                                <input type="text" class="form-control form-control-lg" name="mobile_no" placeholder="Enter the mobile number" minlength="9" maxlength="9" autocomplete="off" autofocus>
                                            </div>
                                            <small class="d-block mt-1 text-muted">Enter your mobile number without leading zero</small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block">Send Code</button>
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
