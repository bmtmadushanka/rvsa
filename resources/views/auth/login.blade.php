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
                                    <h4 class="nk-block-title">Sign-In</h4>
                                </div>
                                <form class="form" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    @include('layouts.messages')
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label required" for="default-01">Email</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control form-control-lg" id="default-01" name="email" placeholder="Enter your email address" value="{{ old('email') }}" maxlength="150" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label required" for="password">Password</label>
                                            <a class="link link-primary link-sm" tabindex="-1" href="{{ route('password.request') }}">Forgot Password?</a>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" tabindex="-1" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password" maxlength="150" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="checkbox-remember" name="remember" {{ old('remember') ? 'checked="checked"' : '' }} />
                                            <label class="form-check-label" for="checkbox-remember">Remember me</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block">Sign in</button>
                                    </div>
                                </form>
                                <div class="form-note-s2 text-center pt-4"> New User? <a href="/register">Create an account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
