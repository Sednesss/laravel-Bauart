<?php

namespace App\Helpers\API;

interface ImageProcessingAPIInterface
{
    function removeBackground($header_params, $body_params, $params_saving_loading);
}
