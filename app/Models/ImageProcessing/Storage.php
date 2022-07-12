<?php

namespace App\Models\ImageProcessing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'key'];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
