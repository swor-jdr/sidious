<?php
namespace Modules\Holonews\Controllers;

use Illuminate\Support\Facades\Storage;

class ImageUploadsController
{
    /**
     * Upload a new image.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload()
    {
        $path = request()->image->store(config('holonews.storage_path'), [
                'disk' => config('holonews.storage_disk'),
                'visibility' => 'public',
            ]
        );

        return response()->json([
            'url' => Storage::disk(config('holonews.storage_disk'))->url($path),
        ]);
    }
}
