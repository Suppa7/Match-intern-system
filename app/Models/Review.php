<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'company_name',
        'selection',
        'province',
        'task',
        'comment',
        'type',
        'score',
        'user_id',
        'submajor'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ImageReview()
    {
        return $this->hasMany(ImageReview::class);
    }
    public function ReviewWelfare()
    {
        return $this->hasMany(ReviewWelfare::class);
    }
    public function UserFavorite()
    {
        return $this->hasOne(UserFavorite::class);
    }
    public function ReportReview()
    {
        return $this->hasMany(ReportedReview::class);
    }
}
