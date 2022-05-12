@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <h2 class="nk-block-title fw-normal">My Profile</h2>
            </div>
        </div><!-- .nk-block-head -->
        <div class="nk-block nk-block-lg">
            <div class="card card-preview">
                <div class="card-inner">
                    @include('layouts.messages')
                    <ul class="nk-nav nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabOverview">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabSecurity">Security</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane pt-1 active" id="tabOverview">
                            <form class="form" method="POST" action="/user/{{ $user->id }}/update">
                                @csrf
                                @method('patch')
                                @include('web.partials.user_profile')
                                <div class="row mt-5 border-top">
                                    <div class="col-md-6">
                                        <div class="form-group mt-5">
                                            <label class="form-label required" for="input-password">Please enter your password to confirm the changes</label>
                                            <div class="form-control-wrap">
                                                <input type="password" class="form-control" id="input-password" name="password" required autocomplete="off" placeholder="Enter Password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center pt-5 mt-5">
                                    <button class="btn btn-lg btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane pt-1" id="tabSecurity">
                            <form class="form ajax" method="POST" action="user/{{ $user->id }}/update-password">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mt-4 mb-3">
                                            <label class="form-label required" for="input-current-password">Current Password</label>
                                            <div class="form-control-wrap">
                                                <input type="password" class="form-control" id="input-current-password" name="current_credentials" required autocomplete="off" placeholder="Enter Current Password">
                                            </div>
                                            <div class="feedback"></div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label required" for="input-new-password">New Password</label>
                                            <div class="form-control-wrap">
                                                <input type="password" class="form-control" id="input-new-password" name="password" required="" autocomplete="off" maxlength="150" placeholder="Enter Password" />
                                            </div>
                                            <div class="feedback"></div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label required" for="input-confirm-password">Confirm Password</label>
                                            <div class="form-control-wrap">
                                                <input type="password" class="form-control" id="input-confirm-password" name="password_confirmation" required="" autocomplete="off" maxlength="150" placeholder="Re-Enter Password" />
                                            </div>
                                            <div class="feedback"></div>
                                        </div>
                                        <div class="form-group text-center my-5">
                                            <button class="btn btn-lg btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
