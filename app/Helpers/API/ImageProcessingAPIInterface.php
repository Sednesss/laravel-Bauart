<?php

namespace App\Helpers\API;

interface ImageProcessingAPIInterface
{
    function removeBackground($body_params, $params_saving_loading, $header_params);
}
