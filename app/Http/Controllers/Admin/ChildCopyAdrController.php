<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChildCopyAdr;
use App\Traits\AdrTrait;
use App\Traits\ChildCopyTrait;
use App\Traits\CommonTrait;
use App\Traits\VersionChangeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ChildCopyAdrController extends Controller
{
    use CommonTrait, AdrTrait, ChildCopyTrait, VersionChangeTrait;

    public function edit(Request $request, ChildCopyAdr $adr)
    {
        return view('admin.adr.create', [
            'adr' => $adr,
            'evidence_types' => $this->get_evidence_types(),
            'child_copy_id' => $adr->child_copy_id,
            'action' => 'admin/child-copy/adr',
        ]);
    }

    public function delete_adr(Request $request, ChildCopyAdr $adr)
    {
        $this->ajax_verify($request);

        $child_copy_id = $adr->child_copy_id;
        $adr->delete();

        return $this->ajax_msg('success', '', '', "admin/child-copy/$child_copy_id/edit?tab=adrs");

    }

    public function update(Request $request, ChildCopyAdr $adr)
    {
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

    public function upload_extra_documents($request, &$data, $adr_id)
    {
        if (isset($data['document']) && is_object($data['document'])) {
            $data['pdf'] = $adr_id . '/' . time() . mt_rand() . '.pdf';
            $file_path = 'uploads/adrs/' . $adr_id;
            $request->document->move(public_path($file_path), $data['pdf']);
            unset($data['document']);
        }
    }

}
