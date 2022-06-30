<?php

namespace App\Jobs\API;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ixudra\Curl\Facades\Curl;

class ImageProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$absolut_path_file = storage_path('app\public') . '/' . $path_upload;
//        $response = Curl::to('https://api.removal.ai/3.0/remove')
//            ->withFile('image_file', $absolut_path_file, 'image/png', $image_name)
//            ->withHeader('Rm-Token: 62bbf39244d1c5.14406167')
//            ->post();

    }
}
