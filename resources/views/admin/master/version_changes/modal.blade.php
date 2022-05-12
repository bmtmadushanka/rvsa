<a href="#" class="close" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em></a>
<div class="modal-header">
    <h5 class="modal-title">Version Changes - {{ $masterCopy->name }} ({{ $masterCopy->version }})</h5>
</div>
<div class="modal-body">
    @if (!empty($masterCopy->versionChanges['data']))
        <div class="pt-3 pb-4 clearfix">
            <div class="float-right d-flex">
                <div class="align-middle mr-5">
                    <span class="d-inline-block border bg-light-red mr-2" style="width: 20px; height: 20px"> </span> <span class="pos-rel" style="bottom: 5px">Old / Deleted Value</span>
                </div>
                <div class="align-middle">
                    <span class="d-inline-block border bg-light-green mr-2" style="width: 20px; height: 20px"> </span> <span class="pos-rel" style="bottom: 5px">New / Added Value</span>
                </div>
            </div>
        </div>
        <table class="table table-bordered">
        <tbody>
            @include('admin.master.version_changes.content')
        </tbody>
        </table>
    @else
    <div class="p-5 text-center">
        <em class="icon ni ni-info mr-1 fs-20px pos-rel" style="top: 3px"></em> No changes available
    </div>
    @endif
    <div class="nk-modal-action text-center my-4">
        <a href="#" class="btn btn-outline-secondary" data-dismiss="modal">Return</a>
    </div>
</div>
