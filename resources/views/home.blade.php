@extends('layouts.public.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card w-100">
                    <div class="card-body p-0">
                        <div class="search-wrapper">
                            <style>
                                .search-wrapper {
                                    background: #ccc;
                                    height: 500px;
                                    background: url('/images/road.png') no-repeat;
                                    background-size: 100% 100%;
                                    width: 100%;
                                    position: relative;
                                }

                                #search-box {
                                    position: absolute;
                                    top: 35%;
                                    width: 100%;
                                    width: 90%;
                                    left: 5%;
                                    background-color: rgba(0,0,0,0.75);
                                    padding: 25px 50px;
                                }

                                .overlay {
                                    position: absolute; /* Sit on top of the page content */
                                    width: 100%; /* Full width (cover the whole page) */
                                    height: 100%; /* Full height (cover the whole page) */
                                    background-color: rgba(0,0,0,0.8); /* Black background with opacity */
                                }
                            </style>

                            <div class="shadow-sm mx-auto" id="search-box">
                                <div>
                                    <div class="input-group p-4">
                                        <select class="form-control" style="height: 45px">
                                            <option>Select the Make</option>
                                            <option>Toyota</option>
                                            <option>Nissan</option>
                                        </select>
                                        <input type="text" class="form-control" placeholder="Model" style="height: 45px">
                                        <button class="btn btn-success" type="button" id="button-addon2" style="height: 45px"><i class="fa fa-search mr-1"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts-post')
    {{--<script src="/js/list.js"></script>--}}
@endpush
