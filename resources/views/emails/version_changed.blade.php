@include('emails.header')
<tr>
    <td>Dear {{ $user->first_name }} {{ $user->last_name }},</td>
</tr>
<tr>
    <td class="text-center">
        Kindly note that model report {{ $report->make }} {{ $report->model }} {{ $report->model_code }} {{ str_replace('<br>', ' ', $report->description) }} has been updated and the new version is available to purchase from our portal.
        <div style="margin-top: 20px">
            <a class="btn" href="{{ config('app.url') . '/reports?id=' . $report->id }}">Purchase</a>
            <a class="btn" href="{{ config('app.url') . '/updates' }}">View All Updates</a>
        </div>
    </td>
</tr>
@include('emails.footer')
