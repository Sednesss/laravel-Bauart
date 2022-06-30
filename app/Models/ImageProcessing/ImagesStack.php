<?php

namespace App\Models\ImageProcessing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagesStack extends Model
{
    use HasFactory;

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
