<?php

namespace App\Helpers\API;

use Ixudra\Curl\Facades\Curl;

class ClipdropAPI implements ImageProcessingAPIInterface
{
    private string $url_remove_background = 'https://apis.clipdrop.co/remove-background/v1';
    private string $api_key;

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    public function removeBackground($body_params, $params_saving_loading, $header_params = [])
    {
        return Curl::to($this->url_remove_background)
            ->withFile('image_file', $params_saving_loading['path_to_loading'], 'image/png', $body_params['image_name'])
            ->withHeader("x-api-key: $this->api_key")
            ->returnResponseObject()
            ->post();
    }
}
