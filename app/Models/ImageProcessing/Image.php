<?php

namespace App\Models\ImageProcessing;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'storage_id', 'images_stack_id', 'name', 'status', 'path_origin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function images_stack()
    {
        return $this->belongsTo(ImagesStack::class);
    }
}
