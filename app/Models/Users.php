<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Users extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'tipe',
        'tempat_lahir',
        'tanggal_lahir',
        'j_k',
        'agama',
        'no_hp',
        'alamat',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('user')
            ->logFillable();
    }
}
