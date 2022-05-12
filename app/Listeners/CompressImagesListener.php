<?php

namespace App\Listeners;

use App\Events\CompressImagesEvent;
use App\Models\ChildCopy;
use App\Traits\CommonTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CompressImagesListener implements ShouldQueue
{
    use CommonTrait;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CompressImagesEvent  $event
     * @return void
     */
    public function handle(CompressImagesEvent $event)
    {
        $directory = public_path('uploads/images/child/' . $event->child_copy_id);
        foreach ($this->traverse_hierarchy($directory) AS $image) {
            $this->compress_images($image, $image, 50);
        }

    }

    private function traverse_hierarchy($path)
    {
        $return_array = array();
        $dir = opendir($path);
        while(($file = readdir($dir)) !== false)
        {
            if($file[0] == '.') continue;
            $fullpath = $path . '/' . $file;
            if(is_dir($fullpath))
                $return_array = array_merge($return_array, $this->traverse_hierarchy($fullpath));
            else
                $return_array[] = $fullpath;
        }
        return $return_array;
    }
}
