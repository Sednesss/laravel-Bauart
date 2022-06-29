<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoadingImageRequest;
use App\Http\Resources\API\ImageResource;
use App\Models\ImageProcessing\Image;
use Illuminate\Support\Facades\Storage;
use Ixudra\Curl\Facades\Curl;

class LoadingImageController extends Controller
{
    public function loading(LoadingImageRequest $request)
    {
        $request->validated();

        $temp_image = $request['image'];
        $image_name = $temp_image->getClientOriginalName();

        $path_upload = $temp_image->store(config('imagestorage.disks.local.storage_path'), 'public');

        $input = [
            'user_id' => $request->user()->id,
            'storage_id' => 1,
            'name' => $temp_image->getClientOriginalName(),
            'path_origin' => $path_upload,
        ];

        $image = Image::create($input);

        //removal.ai api
        $absolut_path_file = storage_path('app\public') . '/' . $path_upload;
        $response = Curl::to('https://api.removal.ai/3.0/remove')
            ->withFile('image_file', $absolut_path_file, 'image/png', $image_name)
            ->withHeader('Rm-Token: 62bbf39244d1c5.14406167')
            ->post();

        $success = [
            'name' => $temp_image->getClientOriginalName(),
            'path' => $path_upload,
            'date' => $image['created_at'],
            'message' => 'Image loading successfully.',
            'response_api' => $response,
        ];

        return new ImageResource($success);
    }
}
