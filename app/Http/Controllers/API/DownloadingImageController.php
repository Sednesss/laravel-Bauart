<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DownloadingImageRequest;
use App\Http\Resources\API\ImageResource;
use App\Models\ImageProcessing\Image;

class DownloadingImageController extends Controller
{
    public function downloading(DownloadingImageRequest $request)
    {
        $request->validated();

        //all images this user
        $image_name = [];
        foreach ($request->user()->images as $image) {
            $image_name[] = $image->name;
        }
        $success = [
            'names_images' => $image_name,
            'message' => 'Images downloading successfully.',
        ];
        return new ImageResource($success);
    }
}
