<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DownloadingImagesStackRequest;
use App\Models\ImageProcessing\ImagesStack;
use ZanySoft\Zip\Zip;

class DownloadingImagesStackController extends Controller
{
    public function downloading(DownloadingImagesStackRequest $request)
    {
        $request->validated();

        $images_stack_id = $request['images_stack_id'];

        $zip_file_name = date('Y_m_d_His') . '_images_' . $request->user()->id . '.zip';
        $zip = Zip::create($zip_file_name);

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $zip->setPath(config('imagestorage.OS_system.win.path_downloading_images'));
        } else {
            $zip->setPath(config('imagestorage.OS_system.linux.path_downloading_images'));
        }

//        $is_users_stack = $request->user()->images_stack
//            ->where('id', '=', $images_stack_id);

//        $error['error'] = ['Error loading images.'];
//        $error['message'] = 'The transmitted image does not belong to the user.';
//        return new ErrorResource($error);

        $image_list = ImagesStack::find($images_stack_id)->images;

        foreach ($image_list as $image) {
            $zip->add($image->path_processed);
        }
        $zip->close();
        $path_archive = $zip->getFileObject()->getRealPath();

        return response()->download($path_archive);
    }
}
