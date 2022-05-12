<div class="page-content text-justify">
    <h2>ODOMETER CHECKS:</h2>
    <div style="margin-top: 25px">
        <div class="mb-4">RAW to check the odometer details contained within an original Export Certificate or other official document & then record details below.</div>
        <div class="mb-5" style="position: relative">RAW input:
            <span class="placeholder" data-id="22.1" style="margin-right: 50px">Value</span>
            Date:
            <span class="placeholder" data-id="22.2">Value</span>
        </div>
        <div style="position: relative" class="mb-5">Record Odometer reading on the actual vehicle
            <span class="placeholder" data-id="22.3">kms</span>
        </div>
        <p>RAW to add the actual odometer reading details onto the Consumer Information Notice</p>
    </div>
    <div class="mt-3 mb-3">AVV to check that the odometer details contained within an original export certificate or other official document are in fact the same as confirm by the RAW recorded information above. A clear copy along with a photograph of the odometer reading should then be uploaded into the AVV Model Report storage file. In absence of an export certificate or other official document being available other items (service stickers, service handbook, recall stickers, auction documents or condition of the vehicle) may be used to establish the authenticity of the odometer reading being displayed in the actual vehicle.</div>
    <div>The AVV may <b>not</b> accept that the odometer accurately reflects the true distance travelled by the vehicle due to unknown circumstances (odometer is faulty or has been tampered with or due the vehicles condition). The AVV must then record in the comments section below the reasons for forming this opinion. The inspection of the vehicle may then continue. </div>
    <div class="clearfix">
        @include('web.reports.partials.raw_approved_short')
    </div>
    <div class="clearfix">
        @include('web.reports.partials.avv_approved_short')
    </div>
    <div style="margin-top: 40px">
        @include('web.reports.partials.avv_signature')
    </div>
    <div class="clearfix"></div>
    <div>
        <b>Comments:</b>
    </div>
</div>
