<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoadingImageRequest;
use App\Http\Resources\API\ImageResource;
use App\Models\ImageProcessing\Image;

class LoadingImageController extends Controller
{
    public function loading(LoadingImageRequest $request)
    {
        $request->validated();

        $temp_image = $request['image'];

        $path_upload = $temp_image->store(config('imagestorage.disks.local.storage_path'), 'public');

        $input = [
            'user_id' => $request->user()->id,
            'storage_id' => 1,
            'name' => $temp_image->getClientOriginalName(),
            'path_origin' => $path_upload,
        ];

        $image = Image::create($input);

        $success = [
            'name' => $temp_image->getClientOriginalName(),
            'path' => $path_upload,
            'date' => $image['created_at'],
            'message' => 'Image loading successfully.',
        ];

        return new ImageResource($success);
    }
}
