<a href="#" class="close" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
<div class="modal-header">
    <h5 class="modal-title">Version Changes - {{ $childCopy->name }} ({{ $childCopy->version }})</h5>
</div>
<div class="modal-body">
    @include('admin.child_copies.version_changes')
    <div class="nk-modal-action text-center my-4">
        <a href="#" class="btn btn-outline-secondary" data-dismiss="modal">Return</a>
    </div>
</div>
