@include('emails.header')
<tr>
    <td>Dear {{ $user->first_name }} {{ $user->last_name }},</td>
</tr>
<tr>
    <td class="text-center">
        New model report of {{ $report->make }} {{ $report->model }} {{ $report->model_code }} {{ str_replace('<br>', ' ', $report->description) }} has been added and available to purchase from our portal.
        <div style="margin-top: 20px">
            <a class="btn" href="{{ config('app.url') . '/reports?id=' . $report->id }}">Purchase</a>
        </div>
    </td>
</tr>
@include('emails.footer')
