<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DownloadingImageRequest;
use ZanySoft\Zip\Zip;

class DownloadingImageController extends Controller
{
    public function downloading(DownloadingImageRequest $request)
    {
        $request->validated();

        $images_id = $request['images_id'];

        $zip_file_name = date('Y_m_d_His') . '_images_' . $request->user()->id . '.zip';
        $zip = Zip::create($zip_file_name);
        $zip->setPath(storage_path('app\public'));

        $image_list = $request->user()->images
            ->whereIn('id', $images_id);

        foreach ($image_list as $image) {
            $zip->add($image->path_processed);
        }
        $zip->close();
        $path_archive = $zip->getFileObject()->getRealPath();

        return response()->download($path_archive);
    }
}
