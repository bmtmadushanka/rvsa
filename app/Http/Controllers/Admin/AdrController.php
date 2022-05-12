<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adr;
use App\Models\ChildCopyAdr;
use App\Traits\AdrTrait;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class AdrController extends Controller
{
    use CommonTrait, AdrTrait;

    public function index()
    {
        $adr_sorted = [];
        foreach (Adr::all() AS $adr) {
            $adr_sorted[str_replace('/', '.', $adr['number'])] = $adr;
        }
        ksort($adr_sorted);

        return view('admin.adr.list', [
            'adrs' => $adr_sorted
        ]);
    }

    public function create()
    {
        return view('admin.adr.create', [
            'evidence_types' => $this->get_evidence_types(),
            'action' => 'admin/adr',
            'image_upload_url' => 'adr/images'
        ]);
    }

    public function store(Request $request)
    {
        $this->ajax_verify($request);

        $validator = Validator::make($request->all(), [
            'number' => ['required', 'string', 'max:10', 'unique:adrs,number,NULL,id,deleted_at,NULL'],
            'name' => ['required', 'string', 'max:150'],
        ]);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        $data = $request->all();
        $this->format_adr_data($data);

        $data['created_by'] = Auth::user()->id;


        $adr = Adr::create($data);
        return $this->ajax_msg('success', '', '', 'admin/adr');
    }

    public function edit(Request $request, Adr $adr)
    {
        return view('admin.adr.create', [
            'adr' => $adr,
            'evidence_types' => $this->get_evidence_types(),
            'action' => 'admin/adr'
        ]);
    }

    public function update(Request $request, Adr $adr)
    {
        $this->ajax_verify($request);

        $validator = Validator::make($request->all(), [
            'number' => ['required', 'string', 'max:10', 'unique:adrs,number,'. $adr->id .',id,deleted_at,NULL'],
            'name' => ['required', 'string', 'max:150'],
        ]);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        $data = $request->all();
        $this->format_adr_data($data);

        try {
            $adr->update($data);
        } catch (\Exception $e) {
            report($e);
            Log::error($e->getMessage());
            dd('Unable to update the ADR. Please contact your System Administrator');
        }

        return $this->ajax_msg('success','', '', 'admin/adr');
    }

    public function destroy(Request $request, Adr $adr)
    {
        $this->ajax_verify($request);

        if ($adr->is_common_adr) {
            return $this->ajax_msg('error', 'Default ADRs cannot be deleted');
        }

        $adr->delete();
        return $this->ajax_msg('success', '', '', true);

    }

    public function delete_attachment(Request $request, ChildCopyAdr $adr)
    {
        $adr->update(['pdf' => NULL]);
        return $this->ajax_msg('success', 'The attachment has been deleted successfully', '', true);
    }

    public function cache_images(Request $request)
    {
        $validator = Validator::make($request->all(), ['file' => 'required|mimes:jpg,jpeg,gif,png|max:2048']);

        if ($validator->fails()) {
            return $this->ajax_validate($validator->messages());
        }

        $fileName = time() . mt_rand() . '.' .$request->file->extension();
        $file_path = 'uploads/images/adrs/' . date('ymd') . '/';
        $request->file->move(public_path($file_path), $fileName);

        $this->compress_images(public_path($file_path . $fileName), public_path($file_path . $fileName), 50);

        return $this->ajax_msg('success', '', ['url' => URL::to($file_path . $fileName)]);

    }

}
