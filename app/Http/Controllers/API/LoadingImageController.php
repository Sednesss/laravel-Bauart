<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoadingImageRequest;
use App\Http\Resources\API\ImageResource;
use App\Jobs\API\ImageProcessingJob;
use App\Models\ImageProcessing\Image;
use App\Models\ImageProcessing\ImagesStack;
use Illuminate\Support\Facades\Storage;
use Ixudra\Curl\Facades\Curl;

class LoadingImageController extends Controller
{
    public function loading(LoadingImageRequest $request)
    {
        $request->validated();

        $input_image_stack = [
            'user_id' => $request->user()->id
        ];
        $images_stack = ImagesStack::create($input_image_stack);

        $images_name = [];

        $temp_images = $request['images'];
        foreach ($temp_images as $key => $temp_image) {
            $image_name = $temp_image->getClientOriginalName();
            $path_upload = $temp_image->store(config('imagestorage.disks.local.storage_path_upload'), 'public');

            $input_image = [
                'user_id' => $request->user()->id,
                'storage_id' => 1,
                'images_stack_id' => $images_stack->id,
                'name' => $image_name,
                'path_origin' => $path_upload,
            ];
            $image = Image::create($input_image);

            $images_name[] = ['image_name' => $image_name];
        }

        //Job processing images (stack_id)
        dispatch(new ImageProcessingJob($images_stack->id));

        $success = [
            'names_images' => array_column($images_name, 'image_name'),
            'message' => 'Image loading successfully.',
        ];
        return new ImageResource($success);
    }
}
