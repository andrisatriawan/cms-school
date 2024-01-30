<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pengaduan extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'pengaduans';
    protected $fillable = [
        'kode',
        'nama',
        'instansi',
        'no_hp',
        'email',
        'jenis',
        'isi_pengaduan',
        'file'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('pengaduan')
            ->logFillable();
    }
}
