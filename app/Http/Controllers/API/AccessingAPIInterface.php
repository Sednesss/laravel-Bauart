<?php

namespace App\Http\Controllers\API;

interface AccessingAPIInterface
{
    public function requestAPI($method, $url, $header_params, $body_params);
}