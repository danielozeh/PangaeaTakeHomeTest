<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{
    use HasFactory;

    protected $table = 'subscribers';

    protected $fillable = [
        'topic_id',
        'url'
    ];

    public function topic() {
        return $this->belongsTo(Topics::class);
    }
}
