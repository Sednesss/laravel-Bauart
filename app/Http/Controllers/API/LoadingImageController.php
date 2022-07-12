<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoadingImageRequest;
use App\Http\Resources\API\ImageResource;
use App\Jobs\API\ImageProcessingJob;
use App\Models\ImageProcessing\Image;
use App\Models\ImageProcessing\ImagesStack;
use App\Models\ImageProcessing\Storage;

class LoadingImageController extends Controller
{
    public function loading(LoadingImageRequest $request)
    {
        $validated = $request->validated();

        $storage = Storage::first();
        $auth_user_id = $request->user()->id;
        $input_image_stack = [
            'user_id' => $auth_user_id
        ];
        $images_stack = ImagesStack::create($input_image_stack);

        $images_name = [];

        $temp_images = $validated['images'];
        foreach ($temp_images as $key => $temp_image) {
            $image_name = $temp_image->getClientOriginalName();
            if ($storage->key == 'yandex_cloud') {
                $path_upload = $temp_image->store(config('imagestorage.disks.s3.use_path_style_endpoint'), 's3');
            } else {
                $path_upload = $temp_image->store(config('imagestorage.disks.local.storage_path_upload'), 'public');
            }

            $input_image = [
                'user_id' => $auth_user_id,
                'storage_id' => $storage->id,
                'images_stack_id' => $images_stack->id,
                'name' => $image_name,
                'path_origin' => $path_upload,
            ];
            Image::create($input_image);

            $images_name[] = ['image_name' => $image_name];
        }

        //job processing images (stack_id)
        dispatch(new ImageProcessingJob($images_stack->id));

        $success = [
            'names_images' => array_column($images_name, 'image_name'),
            'message' => 'Images loading successfully.',
        ];
        return new ImageResource($success);
    }
}
