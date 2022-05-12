<a href="#" class="close" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
<div class="modal-header">
    <h5 class="modal-title">{{ isset($user) ? 'Edit' : 'Add' }} Admin</h5>
</div>
<div class="modal-body">
    <form class="form ajax" method="POST" action="admin/manager{{ isset($user) ? '/' . $user->id : '' }}">
    @csrf
    @isset($user) @method('patch') @endisset
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label class="form-label required" for="input-first-name">First Name</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="input-first-name" name="first_name" autocomplete="off" value="{{ $user->first_name ?? '' }}" required maxlength="150" placeholder="Enter First Name">
                </div>
                <div class="feedback"></div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label class="form-label required" for="input-first-last">Last Name</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="input-first-last" name="last_name" autocomplete="off" value="{{ $user->last_name ?? '' }}" required maxlength="150" placeholder="Enter Last Name">
                </div>
                <div class="feedback"></div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label class="form-label required" for="input-email">Email</label>
                <div class="form-control-wrap">
                    <input type="email" class="form-control" id="input-email" name="email" autocomplete="off" value="{{ $user->email ?? '' }}" required maxlength="150" placeholder="Enter Email Address">
                </div>
                <div class="feedback"></div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label class="form-label required" for="input-mobile">Contact No (Mobile)</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">+61</span>
                    </div>
                    <input type="text" class="form-control unsigned-integer" id="input-mobile" name="mobile_no" autocomplete="off" value="{{ $user->mobile_no ?? '' }}" minlength="9" maxlength="9" required  placeholder="Enter Mobile Number">
                    <small class="mt-1 text-muted">Enter your mobile number without leading zero</small>
                </div>
                <div class="feedback"></div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label class="form-label" for="input-role">Role</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="input-role" name="role" autocomplete="off" value="{{ $user->role ?? '' }}" maxlength="150" placeholder="Enter Role">
                </div>
                <div class="feedback"></div>
            </div>
        </div>
    </div>


    @unless(!empty($user))
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label class="form-label required" for="input-password">Password</label>
                    <div class="form-control-wrap">
                        <input type="password" class="form-control" id="input-password" name="password" required autocomplete="off" maxlength="150" placeholder="Enter Password">
                    </div>
                    <div class="feedback"></div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label class="form-label required" for="input-confirm-password">Confirm Password</label>
                    <div class="form-control-wrap">
                        <input type="password" class="form-control" id="input-confirm-password" name="password_confirmation" required autocomplete="off" maxlength="150" placeholder="Re-Enter Password">
                    </div>
                    <div class="feedback"></div>
                </div>
            </div>
        </div>
    @endunless
    <div class="nk-modal-action text-center my-4">
        <a href="#" class="btn btn-outline-secondary" data-dismiss="modal">Return</a>
        <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Save' }}</button>
    </div>
</form>
</div>
