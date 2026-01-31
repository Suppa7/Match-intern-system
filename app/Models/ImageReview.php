<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageReview extends Model
{
    protected $fillable = [
        'review_id',
        'img_name'
    ];
}
