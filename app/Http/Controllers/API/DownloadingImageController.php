<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DownloadingImageRequest;
use App\Http\Resources\API\ErrorResource;
use ZanySoft\Zip\Zip;

class DownloadingImageController extends Controller
{
    public function downloading(DownloadingImageRequest $request)
    {

        $request->validated();

        $images_id = $request['images_id'];

        $zip_file_name = date('Y_m_d_His') . '_images_' . $request->user()->id . '.zip';
        $zip = Zip::create($zip_file_name);

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $zip->setPath(config('imagestorage.OS_system.win.path_downloading_images'));
        } else {
            $zip->setPath(config('imagestorage.OS_system.linux.path_downloading_images'));
        }

//        $error['error'] = ['Error loading images.'];
//        $error['message'] = 'The transmitted image does not belong to the user.';
//        return new ErrorResource($error);

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
