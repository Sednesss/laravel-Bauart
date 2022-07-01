<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoadingImageRequest;
use App\Http\Resources\API\ImageResource;
use App\Jobs\API\ImageStoreJob;
use App\Models\ImageProcessing\Image;
use App\Models\ImageProcessing\ImagesStack;
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
        //$this->dispatch(New ImageStoreJob($request, $request->user()->id));

        $input_image_stack = [
            'user_id' => $request->user()->id
        ];
        $images_stack = ImagesStack::create($input_image_stack);

        $path_upload = $temp_image->store(config('imagestorage.disks.local.storage_path_upload'), 'public');
        $input_image = [
            'user_id' => $request->user()->id,
            'storage_id' => 1,
            'images_stack_id' => $images_stack->id,
            'name' => $image_name,
            'path_origin' => $path_upload,
        ];
        $image = Image::create($input_image);

        //add job processing
        $absolut_path_file = storage_path('app\public') . '/' . $path_upload;
        $response = Curl::to('https://apis.clipdrop.co/remove-background/v1')
            ->withFile('image_file', $absolut_path_file, 'image/png', $image_name)
            ->withHeader('x-api-key: 45365de2fb4d49c0faf46f31d0471cf0505b20b2aacb055e1e442728ff543227c03467db4b21905ce3b05f747fc13a6c')
            ->post();

        $path_processed = config('imagestorage.disks.local.storage_path_processed');
        Storage::disk('public')
            ->put(config('imagestorage.disks.local.storage_path_processed') . '/' . basename($path_upload), $response);
        $image->images_stack_id = $images_stack->id;
        $image->path_processed = $path_processed;

        $image->save();

        $success = [
            'name' => $image_name,
            'message' => 'Image loading successfully.',
        ];

        return new ImageResource($success);
    }
}
