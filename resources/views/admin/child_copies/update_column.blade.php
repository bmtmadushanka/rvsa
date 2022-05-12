<a href="#" class="close" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
<div class="modal-header">
    <h5 class="modal-title">Update {{ ucwords(str_replace('_', ' ', $column)) }}</h5>
</div>
<div class="modal-body">
    <form class="form ajax" method="POST" action="admin/child-copy/{{ $report->id }}/update-column" data-callback="callback_update_child_copy_data_column">
        @csrf
        @method('PATCH')
        @if ($column === 'approval_code')
        <div class="example-alert">
            <div class="alert alert-secondary">
                Entering Approval code will automatically inactivate the older versions (if available) and make this one available for the customers.
            </div>
        </div>
        @endif
        <div class="form-group my-4 pb-1 mx-auto" style="width: {{  $column === 'price' ? '250px' : 'auto' }}">
            <label class="form-label required" for="input-{{ $column }}">{{ ucwords(str_replace('_', ' ', $column)) }}</label>
            <div class="form-control-wrap">
                @if ($column === 'price')
                <div class="input-group">
                    <div class="input-group-append" style="height: 36px">
                        <span class="input-group-text px-2">
                            <span class="input-group-addon p-0 bg-transparent border-0">AUD</span>
                        </span>
                    </div>
                    <input type="text" class="form-control currency text-right" name="price" value="{{ $report->price ? number_format($report->price, 2) : '' }}" id="input-price" required maxlength="12" autocomplete="off"/>
                </div>
                @else
                    <input type="text" class="form-control" name="approval_code" value="{{ $report->approval_code ?? '' }}" id="input-approval_code" required maxlength="150" autocomplete="off"/>
                @endif
            </div>
            <div class="feedback"></div>
        </div>
        <div class="nk-modal-action text-center mt-5 mb-4">
            <a href="#" class="btn btn-mw btn-outline-secondary" data-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-mw btn-primary" data-text="Updating">Update</button>
        </div>
    </form>
</div>
