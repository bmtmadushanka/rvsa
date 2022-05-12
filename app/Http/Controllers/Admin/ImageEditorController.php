<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageEditorController extends Controller
{
    public function store(Request $request)
    {
        $filePath = $request->input('file_path');

        if (! \Str::startsWith($filePath, config('app.asset_url'))) {
            abort(400, 'Image path is not valid.');
        }

        $request->file('image')->move(
            ltrim(pathinfo($filePath, PATHINFO_DIRNAME), '/'),
            basename($filePath)
        );

        return response()->json(['status' => 'success']);
    }
}
