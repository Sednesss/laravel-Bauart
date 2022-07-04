<?php

namespace App\Jobs\API;

use App\Helpers\API\AccessingAPIInterface;
use App\Models\ImageProcessing\Image;
use App\Models\ImageProcessing\ImagesStack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Ixudra\Curl\Facades\Curl;

class ImageProcessingJob implements ShouldQueue, AccessingAPIInterface
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $images_stack_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($images_stack_id)
    {
        $this->images_stack_id = $images_stack_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (Image::where('images_stack_id', $this->images_stack_id)->cursor() as $image) {
            $absolut_path_file = storage_path('app\public') . '/'
                . config('imagestorage.disks.local.storage_path_processed') . '/' . basename($image->path_origin);

            $response = $this->requestAPI('post', 'https://apis.clipdrop.co/remove-background/v1',
                ['api_key' => '45365de2fb4d49c0faf46f31d0471cf0505b20b2aacb055e1e442728ff543227c03467db4b21905ce3b05f747fc13a6c'],
                ['absolut_path_file' => $absolut_path_file, 'image_name' => $image->name]);

            $path_processed = config('imagestorage.disks.local.storage_path_processed') . '/' . basename($image->path_origin);
            Storage::disk('public')->put($path_processed, $response);

            $image->path_processed = $path_processed;
            //$image->status = '124';
            $image->save();

            //$images_stack = ImagesStack::find($this->images_stack_id);
            //$images_stack->status = 'ddd';
            //$images_stack->save();
        }
    }

    public function requestAPI($method, $url, $header_params, $body_params)
    {
        //apis.clipdrop.co
        return Curl::to($url)
            ->withFile('image_file', $body_params['absolut_path_file'], 'image/png', $body_params['image_name'])
            ->withHeader("x-api-key: $header_params[api_key]")
            ->post();
    }
}
