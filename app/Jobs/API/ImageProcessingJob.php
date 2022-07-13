<?php

namespace App\Jobs\API;

use App\Helpers\API\ClipdropAPI;
use App\Helpers\API\RemovalAiAPI;
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

class ImageProcessingJob implements ShouldQueue
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
        $success_processing_stack = true;
        foreach (Image::where('images_stack_id', $this->images_stack_id)->cursor() as $image) {
            $path_to_loading = storage_path('app\public') . '/'
                . config('imagestorage.disks.public.storage_path_upload') . '/' . basename($image->path_origin);
            $path_processed = config('imagestorage.disks.public.storage_path_processed') . '/' . basename($image->path_origin);

            $clipdrop = new ClipdropAPI(config('imagesprocessing.api.clipdrop.api_key'));
            $response = $clipdrop->removeBackground(
                ['image_name' => $image->name],
                ['path_to_loading' => $path_to_loading]);

//            $remove_ai = new RemovalAiAPI(config('imagesprocessing.api.removalai.api_key'));
//            $response = $remove_ai->removeBackground(
//                ['image_name' => $image->name, 'get_file' => 1],
//                ['path_to_loading' => $path_to_loading]);

            $image->path_processed = $path_processed;
            if ($response->status == 200 or $response->status == 0) {
                $image->status = 'processed';
                Storage::disk('public')->put($path_processed, $response->content);
            } else {
                $image->status = 'failed: ' . $response->status;
                $success_processing_stack = false;
            }
            $image->save();
        }

        $images_stack = ImagesStack::find($this->images_stack_id);
        if ($success_processing_stack) {
            $images_stack->status = 'success';
        } else {
            $images_stack->status = 'failed';
        }
        $images_stack->save();
    }
}
