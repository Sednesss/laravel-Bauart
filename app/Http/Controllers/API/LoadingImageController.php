<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoadingImageRequest;
use App\Http\Resources\API\ImageResource;
use App\Jobs\API\ImageStoreJob;
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

        //job store
        //$this->dispatch(New ImageStoreJob($temp_image, $request->user()));

        //store
        //$path_upload = $temp_image->store(config('imagestorage.disks.local.storage_path'), 'public');

        //removal.ai api
        //$absolut_path_file = storage_path('app\public') . '/' . $path_upload;
        $response = Curl::to('https://apis.clipdrop.co/remove-background/v1')
            ->withFile('image_file', 'C:\openserver\domains\laravel-Bauart\laravel-logo-big.png', 'image/png', $image_name)
            ->withHeader('x-api-key: 45365de2fb4d49c0faf46f31d0471cf0505b20b2aacb055e1e442728ff543227c03467db4b21905ce3b05f747fc13a6c')
            ->post();
        dd($response);
        $success = [
            'name' => $image_name,
            'path' => $path_upload,
            'message' => 'Image loading successfully.',
            'response_api' => $response,
        ];

        return new ImageResource($success);
    }
}
