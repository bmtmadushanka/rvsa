@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="{{ route('web_reports') }}"><em class="icon ni ni-arrow-left"></em><span>Model Reports</span></a></div>
                <h2 class="nk-block-title fw-normal">Cart</h2>
            </div>
        </div><!-- .nk-block-head -->
        <div class="nk-block nk-block-lg">
            <div class="card card-preview">
                <div class="card-inner">
                    @unless(empty($cart_data))
                    <form class="form" method="post" action="checkout">
                        @csrf
                        @if($errors->all())
                            <div class="alert alert-danger" role="alert">
                                <p>Oops! We've got an error!</p>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $message)
                                        <li>• {{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <table class="table table-bordered mb-0 w-100">
                            <thead>
                            <tr>
                                <th>VIN Number</th>
                                <th>Make / Model</th>
                                <th class="px-1 text-right">Qty</th>
                                <th class="px-1 text-right">Price (AUD)</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($cart_data AS $k => $cart)
                                <tr style="height: 70px">
                                    <th class="align-middle">
                                       <input class="form-control border-bottom-dashed" name="vin_numbers[{{ $k }}]" value="{{ old('vin_numbers.'. $k ) }}" required autocomplete="off" maxlength="17" minlength="17" placeholder="Please Enter the VIN" />
                                    </th>
                                    <td class="align-middle">{{ $cart['make'] }} - {{ $cart['model'] }}</td>
                                    <td class="px-1 align-middle text-right">1</td>
                                    <td class="px-1 align-middle text-right">{{ number_format($cart['price'], 2) }}</td>
                                    <td class="align-middle" style="width: 30px"><button class="btn btn-sm px-2 btn-outline-danger btn-update-cart" data-method="delete" data-refresh="true" data-id="{{ $k }}" tabindex="-1" style="height: 30px; width: 42px"><em class="icon ni ni-trash"></em></button></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            @if ($discount['percentage'] != 0)
                            <tr style="height: 45px; background: #f9f9f9">
                                <td colspan="2" class="align-middle text-right">Sub Total</td>
                                <td class="px-1 align-middle text-right">{{ count($cart_data) }}</td>
                                <td class="px-1 align-middle text-right"> {{ number_format($total, 2) }}</td>
                                <td></td>
                            </tr>
                            <tr style="height: 40px">
                                <td colspan="2" class="align-middle text-right">Discount ({{ $discount['percentage'] }}%)</td>
                                <td class="px-1 align-middle text-right"></td>
                                <td class="px-1 align-middle text-right"> -{{ number_format($discount['amount'], 2) }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm px-2 btn-outline-danger" id="btn-remove-coupon" tabindex="-1" style="height: 30px; width: 42px"><em class="icon ni ni-trash"></em></button>
                                    <input type="hidden" name="is_remove_coupon" value="0" />
                                </td>
                            </tr>
                            @endif
                            <tr style="height: 45px; background: #f9f9f9">
                                <th colspan="2" class="align-middle text-right">Total</th>
                                <th class="px-1 align-middle text-right">{{ count($cart_data) }}</th>
                                <th class="px-1 align-middle text-right">AUD {{ number_format($total - $discount['amount'], 2) }}</th>
                                <th></th>
                            </tr>
                            @if ($discount['percentage'] == 0)
                            <tr style="height: 45px">
                                <td colspan="5" class="align-middle">
                                    <div class="d-flex justify-content-end py-2">
                                        <div class="mt-1">Have a coupon?</div>
                                        <div class="input-group ml-2" style="width: 200px">
                                            <input type="text" class="form-control text-right" name="coupon_code" maxlength="10" value="" autocomplete="off" placeholder="Coupon Code">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-sm px-2 btn-outline-primary" id="btn-add-coupon"><em class="icon ni ni-plus"></em></button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            </tfoot>
                        </table>
                        <div class="border bg-gray-100 p-2 mt-5">
                            <div>Notice: Please make sure the details entered are correct such as but not limited to Selecting of Correct Vehicle Model and the VIN entered is correct. Kindly note there won’t be any refunds once the payment is processed.</div>
                            <div class="mt-3">
                                Kindly note . Price Quoted is per vehicle per VIN. Example if you got 2 vehicles from the same Make & Model, you need to purchase 2 reports, one for each VIN.
                            </div>

                        </div>
                        <div class="mt-4">
                            <div class="form-group">
                                <div class="custom-control custom-control-xs custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" required="required" name="is_agreed" value="1" id="checkbox-agreement">
                                    <label class="custom-control-label" for="checkbox-agreement">I certify that the details entered by me is accurate and I have double checked the entries. I acknowledge once the payment is made, there won’t any refunds available under any circumstances. Furthermore, I accept the Terms & Conditions and Privacy Policy of this website.</label>
                                </div>
                            </div>
                            <div class="text-center pt-3 pb-5">
                                <button type="button" class="btn btn-danger" id="btn-checkout"><em class="icon ni ni-paypal-alt mr-1"></em> Checkout</button>
                                <button type="submit" style="display: none"></button>
                            </div>
                            {{--<div class="card" style="width: 400px">
                                <div class="card-body" style="background: #f9f9f9">
                                    <h6>PayPal Test Credentials</h6>
                                    <div><strong>Email: </strong> sb-dttrz6381574@personal.example.com</div>
                                    <div><strong>Password: </strong> 0h=)74gR</div>
                                </div>
                            </div>--}}
                        </div>
                    </form>
                    @else
                        <div class="border text-center" style="padding: 20px 0 50px">
                            <div>
                                <em class="icon ni ni-cart" style="font-size: 60px"></em>
                                <div class="mt-2" style="font-size: 1.25rem">Your cart is empty</div>
                            </div>
                        </div>
                    @endunless
                </div>
            </div><!-- .card-preview -->
        </div> <!-- nk-block -->
    </div><!-- .components-preview -->
    <script>
        $(function() {

            $('body').on('click', '#btn-add-coupon', function() {
                let $$ = $(this);
                if ($$.closest('td').find('input').val().length <= 0) {
                    notify('error', 'Coupon code is required and cannot be empty');
                } else {
                    loadingButton($$, true, false);
                    $$.closest('form').find('#checkbox-agreement').removeAttr('required').prop('checked', false);
                    submitForm($$.closest('form')[0]);
                }
            });

            $('body').on('click', '#btn-checkout', function() {
                let $$ = $(this)
                $$.closest('form').find('#checkbox-agreement').attr('required', 'required');
                submitForm($$.closest('form')[0]);

            });

            $('body').on('click', '#btn-remove-coupon', function() {
                let $$ = $(this);
                loadingButton($$, true, false);
                $$.next('input[name="is_remove_coupon"]').val(1);
                $$.closest('form').find('#checkbox-agreement').removeAttr('required').prop('checked', false);
                submitForm($$.closest('form')[0]);
            });

            function submitForm(form)
            {
                if (form.checkValidity()) {
                    form.submit();
                } else {
                    form.reportValidity();
                }
            }
        });
    </script>
@endsection
