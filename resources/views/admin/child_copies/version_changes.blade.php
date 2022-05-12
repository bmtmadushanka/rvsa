@if (!empty($childCopy->versionChanges['data']))
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
    @if ($childCopy->versionChanges->reference_type === 'adr')
        <div class="mt-1 mb-4 pb-2">
            <p style="color: #ccc; font-size: 22px"><span class="mr-3"><b>Source ADR:</b></span> {{ $childCopy->versionChanges->reference->parent->number }} {{ $childCopy->versionChanges->reference->parent->name }}</p>
        </div>
    @endif
    <table class="table table-bordered">
    <tbody>
    @if (!empty($childCopy->versionChanges['data']))
        @foreach($changes AS $key => $change)
        @if ($key === 'ADR List') @continue @endif
        <tr>
            <td style="width: 250px">{{ $key }}</td>
            <td {{ $key == 'Master Copy' ? 'colspan=2' : '' }}>
                <div>{!! Diff::show($change['old'], $change['new'])  !!} </div>
            </td>
        </tr>
        @if ($key == 'Master Copy')
            @include('admin.master.version_changes.content')
        @endif
        @endforeach
    @endif

    @if (!empty($childCopy->versionChanges['data']['adr_list']))
        <tr>
            <td style="width: 250px">ARDs <br/>
                <small class="text-muted">(newly added & recently removed only)</small>
            </td>
            <td>
                @foreach($childCopy->versionChanges['data']['adr_list'] AS $key => $adrs)
                <div class="w-100 mb-1 {{ $key === 'added' ? 'bg-light-green' : 'bg-light-red' }}">
                    @foreach ($adrs AS $adr)
                    <span class="border px-1 text-center d-inline-block" style="width: 60px; border-color: #0a0f18 !important; margin-bottom: 4px">{{ $adr }}</span>
                    @endforeach
                </div>
                @endforeach
            </td>
        </tr>
    @endif
    </tbody>
    </table>
@else
<div class="p-5 text-center">
    <em class="icon ni ni-info mr-1 fs-20px pos-rel" style="top: 3px"></em> No changes available
</div>
@endif
