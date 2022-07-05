<?php

namespace App\Helpers\API;

use Ixudra\Curl\Facades\Curl;

class ClipdropAPI implements ImageProcessingAPIInterface
{
    public function removeBackground($url, $header_params, $body_params, $params_saving_loading)
    {
        return Curl::to($url)
            ->withFile('image_file', $params_saving_loading['path_to_loading'], 'image/png', $body_params['image_name'])
            ->withHeader("x-api-key: $header_params[api_key]")
            //->withContentType('image/png')
            ->download($params_saving_loading['path_to_saving'])
            ->post();
    }
}
