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

        //dd($request->image);
        //job store
        $this->dispatch(New ImageStoreJob($request, $request->user()->id));

        $success = [
            'name' => $image_name,
            'message' => 'Image loading successfully.',
        ];

        return new ImageResource($success);
    }
}
