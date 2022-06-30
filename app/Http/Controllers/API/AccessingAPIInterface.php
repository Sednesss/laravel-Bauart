<?php

namespace App\Http\Controllers\API;

interface AccessingAPIInterface
{
    public function sendRequest($path);
}
