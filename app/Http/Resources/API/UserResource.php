<?php

namespace App\Http\Resources\API;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'success' => true,
            'message' => $this['message'],
            'user' => [
                'email' => $this['email'],
                'token-type' => 'Bearer',
                'token' => $this['token'],
            ],
        ];
    }
}
