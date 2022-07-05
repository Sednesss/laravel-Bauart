<?php

namespace App\Helpers\API;

interface ImageProcessingAPIInterface
{
    function removeBackground($url, $header_params, $body_params, $params_saving_loading);
}
