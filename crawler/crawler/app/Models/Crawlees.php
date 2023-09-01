<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crawlees extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'screenshot_path',
        'contents'
    ];
}
