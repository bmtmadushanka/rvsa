@foreach($masterCopy->versionChanges['data'] AS $pages)
    @foreach ($pages AS $page => $data)
        @if (in_array($data['status'] , ['created', 'deleted']))
            <tr>
                <td class="text-nowrap">Page {{ str_replace('page_', '', $page) }}</td>
                <td colspan="3">
                    <div class="bg-light-{{ $data['status'] === 'created' ? 'green' : 'red' }}">{{ ucfirst($data['status']) }}</div>
                </td>
            </tr>
        @else
            @foreach ($data['changes'] AS $key => $change)
                <tr>
                    @if ($loop->first)
                        <td class="text-nowrap" rowspan="{{ count($data['changes']) }}">Page {{ str_replace('page_', '', $page) }}</td>
                    @endif
                    <td style="width: 150px">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                    <td>
                        <div>{!! Diff::show($change['old'], $change['new']) !!} </div>
                    </td>
                </tr>
            @endforeach
        @endif
    @endforeach
@endforeach
