<?php

namespace App\Helpers\API;

use Ixudra\Curl\Facades\Curl;

class RemovalAiAPI implements ImageProcessingAPIInterface
{
    public function removeBackground($url, $header_params, $body_params, $params_saving_loading)
    {
        return Curl::to($url)
            ->withData(array('get_file' => $body_params['get_file']))
            ->withFile('image_file', $body_params['absolut_path_file'], 'image/png', $body_params['image_name'])
            ->withHeader("Rm-Token: $header_params[api_key]")
            ->returnResponseObject()
            ->post();
    }
}
