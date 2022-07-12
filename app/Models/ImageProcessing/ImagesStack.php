<?php

namespace App\Models\ImageProcessing;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagesStack extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getPathImages()
    {
        return $this->images()->get()->pluck('path_processed')->toArray();
    }
}
