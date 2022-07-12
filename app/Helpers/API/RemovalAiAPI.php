<?php

namespace App\Helpers\API;

use Ixudra\Curl\Facades\Curl;

class RemovalAiAPI implements ImageProcessingAPIInterface
{
    private string $url_remove_background = 'https://api.removal.ai/3.0/remove';
    private string $api_key;

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    public function removeBackground($body_params, $params_saving_loading, $header_params = [])
    {
        return Curl::to($this->url_remove_background)
            ->withData(array('get_file' => $body_params['get_file']))
            ->withFile('image_file', $params_saving_loading['path_to_loading'], 'image/png', $body_params['image_name'])
            ->withHeader("Rm-Token: $this->api_key")
            ->returnResponseObject()
            ->post();
    }
}
