<form class="ajax form scrollable" method="POST" action="/admin/child-copy{{ isset($childCopy) ? '/' . $childCopy->id : ''}}" id="form-create-child-copy" enctype="multipart/form-data" onsubmit="return false;">
@isset($childCopy) {{ method_field('PATCH') }} @endif
@csrf
<div id="accordion-0" class="accordion">
        {{-- vehicle info --}}
        @include('admin.child_copies.partials.create.vehicle_scope')
        <div class="accordion-item">
            <a href="#" class="accordion-head collapsed" data-toggle="collapse" data-target="#accordion-item-photos" style="background: #f5f5f5">
                <h6 class="title fs-7">04. PHOTOGRAPHS (Mandatory for RAV)</h6>
                <span class="accordion-icon"></span>
            </a>
            <div class="accordion-body collapse" id="accordion-item-photos" data-parent="#accordion-0">
                <div class="accordion-inner">
                    @include('admin.child_copies.partials.create.4_photographs')
                </div>
            </div>
        </div> <!-- RAV photographs -->
        <div class="accordion-item">
            <a href="#" class="accordion-head collapsed" data-toggle="collapse" data-target="#accordion-item-measurements" style="background: #f5f5f5">
                <h6 class="title fs-7">05. MEASUREMENTS</h6>
                <span class="accordion-icon"></span>
            </a>
            <div class="accordion-body collapse" id="accordion-item-measurements" data-parent="#accordion-0">
                <div class="accordion-inner">
                    @include('admin.child_copies.partials.create.5_measurements')
                </div>
            </div>
        </div> <!-- Measurements -->
        <div class="accordion-item">
            <a href="#" class="accordion-head collapsed" data-toggle="collapse" data-target="#accordion-item-adr-mods" style="background: #f5f5f5">
                <h6 class="title fs-7">06. ADR RELATED MODS</h6>
                <span class="accordion-icon"></span>
            </a>
            <div class="accordion-body collapse" id="accordion-item-adr-mods" data-parent="#accordion-0">
                <div class="accordion-inner">
                    @include('admin.child_copies.partials.create.6_adr_mods')
                </div>
            </div>
        </div> <!-- ADR Related Mods -->
        <div class="accordion-item">
            <a href="#" class="accordion-head collapsed" data-toggle="collapse" data-target="#accordion-item-adrs" style="background: #f5f5f5">
                <h6 class="title fs-7">07. ADRs</h6>
                <span class="accordion-icon"></span>
            </a>
            <div class="accordion-body collapse" id="accordion-item-adrs" data-parent="#accordion-0">
                <div class="accordion-inner">
                    @include('admin.child_copies.partials.create.7_adrs')
                </div>
            </div>
        </div> <!-- ADRs -->
        <div class="accordion-item">
            <a href="#" class="accordion-head collapsed" data-toggle="collapse" data-target="#accordion-item-pricing" style="background: #f5f5f5">
                <h6 class="title fs-7">08. MR NUMBER / PRICING</h6>
                <span class="accordion-icon"></span>
            </a>
            <div class="accordion-body collapse" id="accordion-item-pricing" data-parent="#accordion-0">
                <div class="accordion-inner">
                    @include('admin.child_copies.partials.create.8_mr_number_pricing')
                </div>
            </div>
        </div>
    </div>
<div>
    <div class="text-center mt-5 mb-2">
        {{--<button type="button" class="btn btn-outline-secondary justify-content-center align-middle" id="btn-show-preview" data-id="1"><em class="icon ni ni-eye mr-1"></em> PREVIEW</button>--}}
        <button type="button" class="btn btn-outline-primary justify-content-center align-middle" id="btn-save-child-copy" style="width: 120px"><em class="icon ni ni-save mr-1"></em>{{ isset($childCopy) ? 'UPDATE' : 'SAVE' }}</button>
        @if (!isset($childCopy))
        <input type="hidden" name="master_copy_id" value="{{ $master->id }}" />
        @else
        <input type="hidden" name="is_new_version" value="0" />
        @endif
    </div>
</div>
</form>

<script>

    $(function() {

        activateSelectize();

        $('body').on('change', 'input.image[type="file"]', function(e) {
            let $$ = $(this);
            $$.closest('tr').find('img').attr('src', URL.createObjectURL(e.target.files[0]));
        });

        $('body').on('click', '#btn-save-child-copy', function() {
            loadingButton($(this));
            validateChildCopyInputs($(this), {{ $childCopy->id ?? 0 }}, -1);
        })

    })

</script>

@push('styles')
    <link rel="stylesheet" href="/plugins/selectize/selectize.min.css" />
    <style>
        .ptro-holder-wrapper {
            z-index: 1011;
        }
    </style>
@endpush
@push('scripts-post')
    <script src="/plugins/selectize/selectize.min.js"></script>
    <script type="text/javascript" src="/js/plugins/painterro-1.2.70.min.js"></script>
    <script>
        $(function() {
            $('.btn-edit-image').click(function (e) {
                e.preventDefault();
                const img = $(this).prev().attr('src');
                const imgForPtro = img.split('?')[0];
                const ptro = Painterro({
                    hiddenTools: ['clear', 'open'],
                    saveHandler: function (image, done) {
                        const csrfToken = $('meta[name="csrf-token"]').attr('content');
                        const formData = new FormData();
                        formData.append('image', image.asBlob());
                        formData.append('file_path', imgForPtro);
                        // you can also pass suggested filename
                        // formData.append('image', image.asBlob(), image.suggestedFileName());
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '{{ route('image-editor.store') }}', true);
                        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                        xhr.onload = xhr.onerror = function () {
                            // after saving is done, call done callback
                            done(true); //done(true) will hide painterro, done(false) will leave opened
                        };
                        xhr.onloadend = function () {
                            $('img[src="'+ img +'"]').attr('src', imgForPtro + '?t=' + new Date().getTime());
                        }
                        xhr.send(formData);
                    }
                });
                ptro.show(imgForPtro);
            });
        })
    </script>
@endpush
