<style>
    .active .nk-ibx-menu-text, .active .nk-ibx-menu-item .icon {
        color: #526484 !important;
    }
</style>

<div class="nk-block nk-block-lg">
    <div class="nk-ibx">
        @include('web.notifications.aside')
        <div class="nk-ibx-body bg-white p-2 wrapper-table-notifications">
            @include('web.notifications.content')
        </div>
    </div>
</div>
<script>
    $(document).ready( function () {

        $('.datatable').DataTable({
            "dom": 'flrtirp',
            "pageLength": 100,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>
