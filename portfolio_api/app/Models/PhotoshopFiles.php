<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoshopFiles extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'description',
        'file_location',
        'youtube_id'
    ];
}
