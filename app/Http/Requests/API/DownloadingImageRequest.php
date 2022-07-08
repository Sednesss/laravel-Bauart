<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class DownloadingImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'images_id' => ['required', 'array'],
            'images_id.*' => ['required', 'integer'],
        ];
    }
}
