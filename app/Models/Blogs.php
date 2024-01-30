<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Blogs extends Model
{
    // use HasFactory;
    use HasFactory, LogsActivity;
    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'deskripsi',
        'photo'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('blog')
            ->logFillable();
    }
}
