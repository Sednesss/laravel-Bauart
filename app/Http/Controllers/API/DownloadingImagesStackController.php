<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DownloadingImagesStackRequest;
use App\Http\Resources\API\ErrorResource;
use App\Models\ImageProcessing\ImagesStack;
use ZanySoft\Zip\Zip;

class DownloadingImagesStackController extends Controller
{
    public function downloading(DownloadingImagesStackRequest $request)
    {
        $validated = $request->validated();

        $images_stack_id = $validated['images_stack_id'];
        $auth_user_id = $request->user()->id;

        $image_stack = ImagesStack::find($images_stack_id);
        if ($image_stack) {
            if ($image_stack->user->id == $auth_user_id) {

                $zip_file_name = date('Y_m_d_His') . '_images_' . $auth_user_id . '.zip';
                $zip = Zip::create($zip_file_name);

                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $zip->setPath(config('imagestorage.OS_system.win.path_downloading_images'));
                } else {
                    $zip->setPath(config('imagestorage.OS_system.linux.path_downloading_images'));
                }

                $image_list = $image_stack->images;
                foreach ($image_list as $image) {
                    $zip->add($image->path_processed);
                }
                $zip->close();
                $path_archive = $zip->getFileObject()->getRealPath();

                return response()->download($path_archive);
            } else {
                $error['error'] = ['Error loading images.'];
                $error['message'] = 'The transferred stack of images does not belong to the user.';
                return new ErrorResource($error);
            }
        } else {
            $error['error'] = ['Error loading images.'];
            $error['message'] = 'The transferred stack of images was not found.';
            return new ErrorResource($error);
        }
    }
}
