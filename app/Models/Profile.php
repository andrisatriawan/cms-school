<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Profile extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $table = 'profiles';
    protected $fillable = [
        'title',
        'slug',
        'content',
        'photo',
        'order'
    ];

    protected $logAttributes = [
        'title',
        'slug',
        'content',
        'photo',
        'order'
    ];

    protected $logName = 'profile';

    protected $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('profile')
            ->logFillable();
    }
}
