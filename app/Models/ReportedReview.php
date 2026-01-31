<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportedReview extends Model
{
    protected $fillable = [
        'review_id',
        'user_id',
        'report_topic',
        'report_content'
    ];

    public function Review()
    {
        return $this->belongsTo(Review::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
