<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CommonTrait
{
    private $evidence_types = [
        '1/ Evidence type',
        '2/ Evidence type',
        '3/ Evidence type',
        '4/ Evidence type',
        'Other Supporting Information',
        'Photograph Section'
    ];

    private $discussion_subjects = [
        1 => 'General',
        2 => 'Purchase Related',
        3 => 'Changes to Profile',
        4 => 'Payment Issues',
        5 => 'Model Report Download Issues'
    ];

    protected function ajax_verify($request)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        /*else if(empty(Auth::user())){
            abort(401);
        }*/
    }

    protected function ajax_msg($status, $message = '', $data = '', $redirect = '')
    {
        $json_data['status'] = $status;

        if (!empty($message)) {
            $json_data['msg'] = $message;
        }

        if (!empty($data)) {
            $json_data['data'] = $data;
        }

        if (!empty($redirect)) {
            $json_data['redirect'] = $redirect;
        }

        return response()->json($json_data);
    }

    protected function ajax_validate($data)
    {
        $json_data = [];
        foreach ($data->toArray() AS $k => $v) {
            $json_data[$k] = $v[0];
        }

        return response()->json([
            'status' => 'validation',
            'data' => $json_data
        ]);
    }

    protected function get_evidence_types() {
        return $this->evidence_types;
    }

    protected function get_discussion_subjects() {
        return $this->discussion_subjects;
    }

    protected function format_catalog_status_attribute($status)
    {
        return [
            0 => ['text' => 'Inactive', 'color' => 'secondary'],
            1 => ['text' => 'Active', 'color' => 'success']
        ][$status];
    }

    public function compress_images($source, $destination, $quality) {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, $destination, $quality);

        return $destination;
    }

}
