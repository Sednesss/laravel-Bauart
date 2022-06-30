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

        //removal.ai api
        //$absolut_path_file = storage_path('app\public') . '/' . $path_upload;
//        $response = Curl::to('https://apis.clipdrop.co/remove-background/v1')
//            ->withFile('image_file', 'C:\openserver\domains\laravel-Bauart\laravel-logo-big.png', 'image/png', $image_name)
//            ->withHeader('x-api-key: 45365de2fb4d49c0faf46f31d0471cf0505b20b2aacb055e1e442728ff543227c03467db4b21905ce3b05f747fc13a6c')
//            ->post();
//        dd($response);
    }
}
