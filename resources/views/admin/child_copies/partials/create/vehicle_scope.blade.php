<div class="accordion-item">
    <a href="#" class="accordion-head collapsed" data-toggle="collapse" data-target="#accordion-item-vehicle-{{ $prefix ?? 0 }}" style="background: #f5f5f5">
        <h6 class="fs-7 title">01. VEHICLE INFO</h6>
        <span class="accordion-icon"></span>
    </a>
    <div class="accordion-body collapse" id="accordion-item-vehicle-{{ $prefix ?? 0 }}" data-parent="#accordion-{{ $prefix ?? 0 }}">
        <div class="accordion-inner pt-4" style="padding-bottom: 50px">
            @include('admin.child_copies.partials.create.1_vehicle_details')
        </div>
    </div>
</div>
<div class="accordion-item">
    <a href="#" class="accordion-head collapsed" data-toggle="collapse" data-target="#accordion-item-engine-{{ $prefix ?? 0 }}" style="background: #f5f5f5">
        <h6 class="title fs-7">02. ENGINE / TRANSMISSION</h6>
        <span class="accordion-icon"></span>
    </a>
    <div class="accordion-body collapse" id="accordion-item-engine-{{ $prefix ?? 0 }}" data-parent="#accordion-{{ $prefix ?? 0 }}" >
        <div class="accordion-inner" style="padding-bottom: 50px">
            @include('admin.child_copies.partials.create.2_engine')
        </div>
    </div>
</div>
<div class="accordion-item">
    <a href="#" class="accordion-head collapsed" data-toggle="collapse" data-target="#accordion-item-other-variants-{{ $prefix ?? 0 }}" style="background: #f5f5f5">
        <h6 class="title fs-7">03. OTHER VARIANTS</h6>
        <span class="accordion-icon"></span>
    </a>
    <div class="accordion-body collapse" id="accordion-item-other-variants-{{ $prefix ?? 0 }}" data-parent="#accordion-{{ $prefix ?? 0 }}">
        <div class="accordion-inner radio-group">
            @include('admin.child_copies.partials.create.3_other_variants')
        </div>
    </div>
</div>
