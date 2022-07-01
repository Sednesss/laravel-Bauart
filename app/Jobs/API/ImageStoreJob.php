<?php

namespace App\Jobs\API;

use App\Models\ImageProcessing\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImageStoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $temp_image;
    protected $user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($temp_image, $user_id)
    {
        $this->temp_image = $temp_image;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path_upload = $this->temp_image->store(config('imagestorage.disks.local.storage_path'), 'public');

        $input = [
            'user_id' => $this->user_id,
            'storage_id' => 1,
            'name' => $this->temp_image,
            'path_origin' => $path_upload,
        ];

        $image = Image::create($input);

        //add job store
    }
}
