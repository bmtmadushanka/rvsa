<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChildCopy;
use App\Models\ChildCopyMod;
use App\Traits\ChildCopyTrait;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChildCopyModsController extends Controller
{
    use CommonTrait, ChildCopyTrait;

    public function index(Request $request, ChildCopy $childCopy)
    {
        return view('admin.child_copies.mods.list', [
            'childCopy' => $childCopy
        ]);
    }

    public function create(Request $request, ChildCopy $childCopy)
    {
        return view('admin.child_copies.mods.create', array_merge(
            $this->get_common_data(),
            ['childCopy' => $childCopy, 'visible_columns' => []]
        ));
    }

    public function store(Request $request, ChildCopy $childCopy)
    {
        // validation is done in FE using jquery
        $data = $request->all();

        try {

            $childCopy->mods()->create([
                'variant_id' => $childCopy->mods()->max('variant_id') + 1,
                'pre' => json_encode($data['pre']),
                'post' => json_encode($data['post']),
                'post_visible_columns' => isset($data['post_visible_columns']) ? json_encode($data['post_visible_columns']) : NULL,
                'sort_order' => $data['sort_order'] ?? NULL,
                'created_by' => $request->user()->id
            ]);

            return redirect('/admin/child-copy/' . $childCopy->batch_id . '/mods');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            dd('Something went wrong! Please contact your System Administrator');
        }

    }

    public function edit(Request $request, ChildCopy $childCopy, $child_copy_mod_id)
    {
        $mod = ChildCopyMod::findOrFail($child_copy_mod_id);

        return view('admin.child_copies.mods.create', array_merge(
            $this->get_common_data(), [
                'childCopy' => $childCopy, 'mod' => $mod, 'visible_columns' => $mod->visible_columns,
            ]
        ));
    }

    public function update(Request $request, ChildCopy $childCopy, $child_copy_mod_id)
    {
        // validation is done in FE using jquery
        $data = $request->all();
        $childCopyMod = ChildCopyMod::findOrFail($child_copy_mod_id);

        try {

            $childCopyMod->update([
                'pre' => isset($data['pre']) ? json_encode($data['pre']) : NULL,
                'post' => json_encode($data['post']),
                'post_visible_columns' => isset($data['post_visible_columns']) ? json_encode($data['post_visible_columns']) : NULL,
                'sort_order' => $data['sort_order'] ?? NULL
            ]);

            return redirect('/admin/child-copy/' . $childCopy->batch_id . '/mods');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            dd('Something went wrong! Please contact your System Administrator');
        }

    }

    public function destroy(Request $request, ChildCopy $childCopy, $child_copy_mod_id)
    {
        $this->ajax_verify($request);

        $childCopy->mods()->firstWhere('id', $child_copy_mod_id)->delete();

        return $this->ajax_msg('success', '', '', true);

    }

}
