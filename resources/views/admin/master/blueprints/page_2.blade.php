<div class="page-content">
    <table class="table-no-border table-index w-100" style="width: 100%">
        <tbody>
        <tr>
            <td></td>
            <td class="text-center" style="width: 150px"><b>Page</b></td>
        </tr>
        <tr>
            <th><a href="#model-report-cover-page">Model Report Cover Page</a></th>
            <td class="text-center">1</td>
        </tr>
        <tr>
            <th>Contents</th>
            <td class="text-center">2-3</td>
        </tr>
        @foreach ($indexes AS $index)
        <tr>
            @if (isset($index['level']))
                {{ $index['level'] == 1 ? '<th>' : '<td>' }}
                <a href="#{{ str_replace(['-amp-', '-ndash-'], '-', Str::slug($index['text'])) }}">{{ $index['text'] }}</a>
                {{ $index['level'] == 1 ? '</th>' : '</td>' }}
                <td class="text-center">{{ $index['page'] }}</td>
            @else
                <td></td>
                <td></td>
            @endif
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
