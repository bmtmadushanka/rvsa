<div class="row gx-5 mt-3">
    <div class="col-md-6">
        <div class="p-2 text-center border bg-gray-100 font-weight-bold mb-4">
            RAW DETAILS
        </div>
        <div class="form-group">
            <label class="form-label required" for="input-raw-id">RAW ID</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control" id="input-raw-id" name="raw_id" autocomplete="off" value="{{ old('raw_id') ?? ($user->client->raw_id ?? '') }}" required maxlength="150" placeholder="Enter RAW ID">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label required" for="input-raw-company-name">RAW Company Name</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control" id="input-raw-company-name" name="raw_company_name" autocomplete="off" value="{{ old('raw_company_name') ?? ($user->client->raw_company_name ?? '') }}" required maxlength="150" placeholder="Enter RAW Company Name">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="input-raw-trading-name">RAW Trading Name (Optional)</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control" id="input-raw-trading-name" name="raw_trading_name" autocomplete="off" value="{{ old('raw_trading_name') ?? ($user->client->raw_trading_name ?? '') }}" maxlength="150" placeholder="Enter RAW Trading Name">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label required" for="input-abn">ABN</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control unsigned-integer" id="input-abn" name="abn" autocomplete="off" value="{{ old('abn') ?? ($user->client->abn ?? '') }}" minlength="11" maxlength="11" required placeholder="Enter ABN">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="p-2 text-center border bg-gray-100 font-weight-bold mb-4">
            RAW REGISTERED ADDRESS
        </div>
        <div class="form-group">
            <label class="form-label required" for="input-address-line-1">Address Line 1</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control" id="input-address-line-1" name="address_line_1" value="{{ old('address_line_1') ?? ($user->client->address->address_line_1 ?? '') }}" required autocomplete="off" maxlength="150" placeholder="Enter Address Line 1">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="input-address-line-2">Address Line 2</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control" id="input-address-line-2" name="address_line_2" value="{{ old('address_line_2') ?? ($user->client->address->address_line_2 ?? '') }}" autocomplete="off" maxlength="150" placeholder="Enter Address Line 2 (Optional)">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label required" for="input-suburb">Suburb</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control" id="input-suburb" name="suburb" value="{{ old('suburb') ?? ($user->client->address->suburb ?? '') }}" required autocomplete="off" maxlength="150" placeholder="Enter Suburb">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label required" for="input-post-code">Post Code</label>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control unsigned-integer" id="input-post-code" name="post_code" value="{{ old('post_code') ?? ($user->client->address->post_code ?? '') }}" required autocomplete="off" placeholder="Enter Post Code" maxlength="4">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="form-label required" for="select-state">State</label>
                    <div class="form-control-wrap">
                        <select class="form-control" id="select-state" name="state" required>
                            <option value="">Select State</option>
                            <option value="Australian Capital Territory" {{ (old('state') ?? ($user->client->address->state ?? '')) === 'Australian Capital Territory' ? 'selected=selected' : '' }}>Australian Capital Territory</option>
                            <option value="Northern Territory" {{ (old('state') ?? ($user->client->address->state ?? '')) === 'Northern Territory' ? 'selected=selected' : '' }}>Northern Territory</option>
                            <option value="South Australia" {{ (old('state') ?? ($user->client->address->state ?? '')) === 'South Australia' ? 'selected=selected' : '' }}>South Australia</option>
                            <option value="Western Australia" {{ (old('state') ?? ($user->client->address->state ?? '')) === 'Western Australia' ? 'selected=selected' : '' }}>Western Australia</option>
                            <option value="New South Wales" {{ (old('state') ?? ($user->client->address->state ?? '')) === 'New South Wales' ? 'selected=selected' : '' }}>New South Wales</option>
                            <option value="Queensland" {{ (old('state') ?? ($user->client->address->state ?? '')) === 'Queensland' ? 'selected=selected' : '' }}>Queensland</option>
                            <option value="Tasmania" {{ (old('state') ?? ($user->client->address->state ?? '')) === 'Tasmania' ? 'selected=selected' : '' }}>Tasmania</option>
                            <option value="Victoria" {{ (old('state') ?? ($user->client->address->state ?? '')) === 'Victoria' ? 'selected=selected' : '' }}>Victoria</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row gx-5 mt-5">
    <div class="col-md-6">
        <div class="p-2 text-center border bg-gray-100 font-weight-bold mb-4">
            DELEGATE FOR THE MODEL REPORT
        </div>
        <div class="form-group">
            <label class="form-label required" for="input-first-name">First Name</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control" id="input-first-name" name="first_name" autocomplete="off" value="{{ old('first_name') ?? ($user->first_name ?? '') }}" required maxlength="150" placeholder="Enter First Name">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label required" for="input-first-last">Last Name</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control" id="input-first-last" name="last_name" autocomplete="off" value="{{ old('last_name') ?? ($user->last_name ?? '') }}" required maxlength="150" placeholder="Enter Last Name">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label required" for="input-email">Email</label>
            <div class="form-control-wrap">
                <input type="email" class="form-control" id="input-email" name="email" autocomplete="off" value="{{ old('email') ?? ($user->email ?? '') }}" required maxlength="150" placeholder="Enter Email Address">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label required" for="input-mobile">Contact No (Mobile)</label>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+61</span>
                            </div>
                            <input type="text" class="form-control unsigned-integer" id="input-mobile" name="mobile_no" autocomplete="off" value="{{ old('mobile_no') ?? ($user->mobile_no ?? '') }}" minlength="9" maxlength="9" required  placeholder="Enter Mobile Number">
                            <small class="mt-1 text-muted">Enter your mobile number without leading zero</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="form-label" for="input-office-number">Contact No (Office)</label>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+61</span>
                            </div>
                            <input type="text" class="form-control unsigned-integer" id="input-office-number" name="office_no" autocomplete="off" value="{{ old('office_no') ?? ($user->office_no ?? '') }}" minlength="9" maxlength="9" placeholder="Enter Office Number">
                            <small class="mt-1 text-muted">Enter your office number without leading zero</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @unless(isset($user))
        <div class="row mt-3 pt-1">
            <div class="col">
                <div class="form-group">
                    <label class="form-label required" for="input-password">Password</label>
                    <div class="form-control-wrap">
                        <input type="password" class="form-control" id="input-password" name="password" required autocomplete="off" maxlength="150" placeholder="Enter Password">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="form-label required" for="input-confirm-password">Confirm Password</label>
                    <div class="form-control-wrap">
                        <input type="password" class="form-control" id="input-confirm-password" name="password_confirmation" required autocomplete="off" maxlength="150" placeholder="Re-Enter Password">
                    </div>
                </div>
            </div>
        </div>
        @endunless
    </div>
</div>
