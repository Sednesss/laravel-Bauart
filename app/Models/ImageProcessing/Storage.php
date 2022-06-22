<?php

namespace App\Models\ImageProcessing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
