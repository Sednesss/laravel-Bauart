<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DownloadingImageRequest;
use App\Http\Resources\API\ErrorResource;
use App\Models\ImageProcessing\Image;
use ZanySoft\Zip\Zip;

class DownloadingImageController extends Controller
{
    public function downloading(DownloadingImageRequest $request)
    {
        $validated = $request->validated();

        $images_id = $validated['images_id'];
        $auth_user_id = $request->user()->id;

        $image_list = Image::select('id', 'user_id', 'path_processed')
            ->whereIn('id', $images_id)
            ->get();
        if (count($image_list) == count($images_id)) {

            //verification of user ownership
            foreach ($image_list as $image) {
                if ($image->user_id != $auth_user_id) {
                    $error['error'] = ['Error loading images.'];
                    $error['message'] = 'The transmitted image does not belong to the user.';
                    return new ErrorResource($error);
                }
            }

            //adding images to the archive
            $zip_file_name = date('Y_m_d_His') . '_images_' . $auth_user_id . '.zip';
            $zip = Zip::create($zip_file_name);

            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $zip->setPath(config('imagestorage.OS_system.win.path_downloading_images'));
            } else {
                $zip->setPath(config('imagestorage.OS_system.linux.path_downloading_images'));
            }

            $zip->add($image_list->pluck('path_processed')->toArray());
            $zip->close();
            $path_archive = $zip->getFileObject()->getRealPath();

            return response()->download($path_archive);
        } else {
            $error['error'] = ['Error loading images.'];
            $error['message'] = 'The transmitted image was not found.';
            return new ErrorResource($error);
        }
    }
}
