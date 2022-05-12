@extends('layouts.master')
@section('content')
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content ">
                    <div class="row">
                        <div class="nk-block mt-5 pt-5 nk-auth-body wide-lg">
                            <div class="card card-bordered">
                                <div class="card-inner card-inner-lg">
                                    <div class="brand-logo pb-4 text-center">
                                        <h4 class="nk-block-title">Register</h4>
                                    </div>
                                    <form class="form" method="POST" action="{{ route('register') }}">
                                        @csrf
                                        @include('layouts.messages')
                                        @include('web.partials.user_profile')
                                        {{--<div class="form-group">
                                            <div class="custom-control custom-control-xs custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox">
                                                <label class="custom-control-label" for="checkbox">I agree to Dashlite <a href="#">Privacy Policy</a> &amp; <a href="#"> Terms.</a></label>
                                            </div>
                                        </div>--}}
                                        <div class="form-group text-center pt-5 mt-5">
                                            <button type="button" class="btn btn-lg btn-primary" id="btn-register">Register</button>
                                            <button type="submit" class="d-none"></button>
                                        </div>
                                    </form>
                                    <div class="form-note-s2 text-center pt-4"> Already have an account? <a href="{{ route('login') }}"><strong>Sign in instead</strong></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('body').on('click', '#btn-register', function() {
               let $$ = $(this);
               let form = $$.closest('form')[0]

                if (form.checkValidity()) {
                    $$.attr('disabled', true);
                    form.submit();
                } else {
                    form.reportValidity();
                }
            });
        })
    </script>
@endsection
