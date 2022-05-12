<?php

namespace App\Http\Controllers\Web;

use App\Facades\Company;
use App\Http\Controllers\Controller;
use App\Models\ChildCopy;
use App\Models\OrderReport;
use App\Traits\ChildCopyTrait;
use CzProject\PdfRotate\PdfRotate;
use Illuminate\Http\Request;
use PDF;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use ZipArchive;
use Illuminate\Support\Facades\File;

class DownloadController extends Controller
{
    use ChildCopyTrait;

    public function report(Request $request, OrderReport $report)
    {
        if (!$request->user()->is_admin && ($report->order->user->id != $request->user()->id || $report->is_paid != 1)) {
            return redirect()->route('web_user_reports');
        }

        return $this->prepare_download('report', $report);

    }

    public function mark(Request $request, OrderReport $report)
    {
        if (!$request->user()->is_admin && ($report->order->user->id != $request->user()->id || $report->is_paid != 1)) {
            return redirect()->route('web_user_reports');
        }
        return $this->prepare_edit('report', $report);

    }


    private function prepare_edit($type, $report)
    {
        switch ($type) {
            case 'report' : {
                if (auth()->user()->is_admin) {
                    return $this->edit_report([
                        'childCopy' => $report->child,
                        'user' => $report->order->user,
                        'report' => $report
                    ]);
                } else {
                    auth()->user()->downloads()->create(['order_report_id' => $report->id]);
                    auth()->user()->activities()->create(['activity_id' => 5, 'reference' => $report->id]);
                    return $this->edit_report([
                        'childCopy' => $report->child,
                        'user' => auth()->user(),
                        'report' => $report
                    ]);
                }
            }
            case 'consumer': {
                if (auth()->user()->is_admin) {
                    return $this->download_consumer_notice($report);
                } else {
                    auth()->user()->downloads()->create(['order_report_id' => $report->id, 'type' => 'consumer']);
                    auth()->user()->activities()->create(['activity_id' => 18, 'reference' => $report->id]);
                    return $this->download_consumer_notice($report);
                }
            }
        }

    }

    private function edit_report($data)
    {
        $report = [
            'report' => $data['childCopy'],
            'vin' => $data['report']->vin ?? '',
            'user' => $data['user'],
            'pages' => $data['childCopy']->master->pages,
            'adrs' => [],
            'verify_link' => config('app.url') .  '/verify',
            'other_variants' => $this->get_other_variants(),
            'has_headers' => true,
            'mods' => $data['childCopy']['data'],
            'show_version' => true,
            'adr_reference' => '',
            '_vin' => $data['report']->vin ?? "[VIN]"
        ];

        foreach ($data['childCopy']->adrs AS $adr) {
            $report['adrs'][str_replace('/', '.', $adr['number'])] = view('admin.adr.pdf', [
                'adr' => $adr,
                'attach_evidence' => $data['evidence'] ?? FALSE
            ]);
        }
        ksort($report['adrs']);
     
        return view('web.reports.raw', $report);

       

        $file_name = (isset($data['report']->id) ? ('MR' . $data['report']->vin) : ($data['childCopy']->make . ' ' . $data['childCopy']->model . ' ' . $data['childCopy']->model_code . ' Model Report')) . '.pdf';
        return $pdf->download($file_name);

    }

    public function consumer_notice(Request $request, OrderReport $report)
    {
        if (!$request->user()->is_admin && ($report->order->user->id != $request->user()->id || $report->is_paid != 1)) {
            return redirect()->route('web_user_reports');
        }

        return $this->prepare_download('consumer', $report);
    }

    public function child_copy(Request $request, ChildCopy $childCopy)
    {
        if (!$request->user()->is_admin) {
            return redirect()->route('web_user_reports');
        }

        return $this->download_report([
            'childCopy' => $childCopy,
            'user' => $request->user(),
            'evidence' => $request->exists('evidence') ?? FALSE
        ]);

    }

    public function noise_test(Request $request, OrderReport $report)
    {
        if (!$request->user()->is_admin) {
            return redirect()->route('web_user_reports');
        }

        $pdf = PDF::loadView('admin.noise_test_reports.pdf', [
            'report' => $report
        ]);
        return $pdf->download('Noise Test Report MR ' . $report->vin . '.pdf');

    }

    public function sticker(Request $request, OrderReport $report)
    {
        if (!$request->user()->is_admin) {
            return redirect()->route('web_user_reports');
        }

        $pdf = PDF::loadView('admin.master.identification_label', [
            'report' => $report
        ]);
        return $pdf->download(Company::get('code') . ' SVIL - ' . $report->vin . '.pdf');

    }

    private function download_report($data)
    {
        $report = [
            'report' => $data['childCopy'],
            'vin' => $data['report']->vin ?? '',
            'user' => $data['user'],
            'pages' => $data['childCopy']->master->pages,
            'adrs' => [],
            'verify_link' => config('app.url') .  '/verify',
            'other_variants' => $this->get_other_variants(),
            'has_headers' => true,
            'mods' => $data['childCopy']['data'],
            'show_version' => true,
            'adr_reference' => '',
            '_vin' => $data['report']->vin ?? "[VIN]"
        ];

        foreach ($data['childCopy']->adrs AS $adr) {
            $report['adrs'][str_replace('/', '.', $adr['number'])] = view('admin.adr.pdf', [
                'adr' => $adr,
                'attach_evidence' => $data['evidence'] ?? FALSE
            ]);
        }
        ksort($report['adrs']);
        //return view('web.reports.pdf', $report);

        $pdf = PDF::loadView('web.reports.pdf', $report);
        $pdf->setPaper('A4', 'landscape');

        $file_name = (isset($data['report']->id) ? ('MR' . $data['report']->vin) : ($data['childCopy']->make . ' ' . $data['childCopy']->model . ' ' . $data['childCopy']->model_code . ' Model Report')) . '.pdf';
        return $pdf->download($file_name);

    }

    private function download_consumer_notice($report)
    {
        $pdf = PDF::loadView('web.reports.pdf', [
            'report' => $report->child,
            'vin' => $report->vin,
            'pages' => $report->child->master->pages->whereIn('blueprint_id', [26, 27]),
            'user' => $report->order->user,
            'adrs' => [],
            'verify_link' => config('app.url') .  '/verify',
            'has_headers' => false
        ]);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Consumer Notice MR'. $report->vin . '.pdf');
    }

    public function download_adrs(Request $request, ChildCopy $childCopy)
    {
        if (!$request->user()->is_admin) {
            abort(404);
        }

        if (empty($request['adrs'])) {
            return $this->ajax_msg('error', 'Invalid Request. No ADRs are selected');
        }

        $report = [
            'report' => $childCopy,
            /*'vin' => '',*/
            'pages' => [],
            'adrs' => [],
            'user' => auth()->user(),
            'has_headers' => true,
            'verify_link' => config('app.url') . '/verify',
        ];

        $adrs = [];

        foreach ($childCopy->adrs()->findOrFail(explode(',', $request['adrs'])) AS $adr) {
            // Convert empty <p> tags to white X characters.
            $adr['html'] = str_replace('&lt;p&gt;&lt;br&gt;&lt;/p&gt;gt;', htmlentities('<p><span style="color: #fff">X</span><br></p>'), $adr['html']);
            $adr['html'] = str_replace('&lt;p&gt;&amp;nbsp;&lt;\/p&gt;', htmlentities('<p><span style="color: #fff">X</span><br></p>'), $adr['html']);
            $adr['html'] = preg_replace('@&lt;td^@i', htmlentities('<p><span style="color: #fff">X</span><br></p>'), $adr['html']);

            /*return view('admin.adr.pdf', [
                'adr' => $adr,
                'vin' => '',
                'attach_evidence' => true
            ]);exit;*/

            $adrs[str_replace('/', '.', $adr['number'])] = [
                'view' => view('admin.adr.pdf', [
                    'adr' => $adr,
                    'attach_evidence' => true,
                    'ignore_page_breaks' => true,
                ]),
                'pdf' => $adr->pdf,
                'id' => $adr->id,
                'number' => $adr['number']
            ] ;
        }
        ksort($adrs);

        $file_path = public_path('uploads/temp/'. auth()->user()->id . '/' . time() . '/');
        if (!file_exists($file_path)) {
            mkdir($file_path, 0777, true);
        }

        foreach ($adrs as $number => $adr) {
            $report['adrs'] = [];
            $report['adrs'][] = $adr['view'];
            $report['adr_reference'] = 'MR' . $childCopy->name . '-ADR-' . $adr['number'];
            $report['_vin'] = '[VIN]';
            $report['ignore_page_breaks'] = true;
            $pdf = PDF::loadView('web.reports.pdf', $report);
            $pdf->setPaper('A4', 'landscape');

            if (!empty($adr['pdf'])) {

                $pdf_path_1 = $file_path . 1 . time() . mt_rand() . '.pdf';
                $pdf->save($pdf_path_1);

                $pdf_path_2 = $file_path . 2 . time() . mt_rand() . '.pdf';
                $pdf_rotate = new PdfRotate();
                $pdf_rotate->rotatePdf(public_path('uploads/adrs/' . $adr['pdf']), $pdf_path_2, $pdf_rotate::DEGREES_90);

                $oMerger = PDFMerger::init();
                $oMerger->addPDF($pdf_path_1);
                $oMerger->addPDF($pdf_path_2);

                $oMerger->merge('L');
                $oMerger->save($file_path . 'MR' . $childCopy->name . '-ADR-' . str_replace('/', '-', $number . '.pdf'));

            } else {
                $pdf->save($file_path . 'MR' . $childCopy->name . '-ADR-' . str_replace('/', '-', $number . '.pdf'));
            }

        }

        return $this->archive($file_path, $childCopy->name);

    }

    private function prepare_download($type, $report)
    {
        switch ($type) {
            case 'report' : {
                if (auth()->user()->is_admin) {
                    return $this->download_report([
                        'childCopy' => $report->child,
                        'user' => $report->order->user,
                        'report' => $report
                    ]);
                } else {
                    auth()->user()->downloads()->create(['order_report_id' => $report->id]);
                    auth()->user()->activities()->create(['activity_id' => 5, 'reference' => $report->id]);
                    return $this->download_report([
                        'childCopy' => $report->child,
                        'user' => auth()->user(),
                        'report' => $report
                    ]);
                }
            }
            case 'consumer': {
                if (auth()->user()->is_admin) {
                    return $this->download_consumer_notice($report);
                } else {
                    auth()->user()->downloads()->create(['order_report_id' => $report->id, 'type' => 'consumer']);
                    auth()->user()->activities()->create(['activity_id' => 18, 'reference' => $report->id]);
                    return $this->download_consumer_notice($report);
                }
            }
        }

    }

    private function archive($file_path, $name)
    {
        $zip = new ZipArchive;

        $fileName =  public_path('uploads/temp/')  . '/MR'. $name . ' ADRs-' . time() . mt_rand() . '.zip';

        if ($zip->open($fileName, ZipArchive::CREATE) === TRUE)
        {
            $files = \File::files($file_path);

            foreach ($files as $key => $value) {
                $file = basename($value);
                $zip->addFile($value, $file);

            }

            $zip->close();
        }

        array_map('unlink', glob("$file_path/*.pdf"));
        File::deleteDirectory(public_path('uploads/temp/'. auth()->user()->id));
        return response()->download($fileName)->deleteFileAfterSend(true);

    }


    public function report_mark(Request $request)
    {
        dd($request);
        $this->ajax_verify($request);
        $rules = [
            'name' => ['required', 'string', 'max:150'],
            'document' => ['nullable', 'mimes:pdf']
        ];

        if (!$adr->is_common_adr) {
            $rules['number'] = ['required', 'string', 'max:10', Rule::unique('child_copy_adrs')->where(function ($query) use ($request, $adr) {
                return $query->where([
                    'parent_adr_id' => $adr->parent_id,
                    'name' => $request->name
                ])->where('id', '!=', $adr->id);
            })];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        $data = $request->all();
        $this->format_adr_data($data);

       
        try {

            if ($data['is_new_version']) {

                $new_child_copy = $this->duplicate_child_copy($adr->child_copy, true);
                $new_adr = $new_child_copy->adrs()->firstWhere('number', $data['number']);

                $this->upload_extra_documents($request, $data, $new_adr->id);

                $new_adr->update($data);
                $this->change_version_adr($adr->child_copy, $new_child_copy, $adr, $new_adr);
                $adr = $new_adr;

            } else {
                $this->upload_extra_documents($request, $data, $adr->id);
                $adr->update($data);
            }

            return $this->ajax_msg('success','', '', "admin/child-copy/$adr->child_copy_id/edit?tab=adrs");

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            dd('Unable to update the ADR. Please contact your System Administrator');
        }

    }
}
