<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $fillable = [
        'maps',
        'alamat',
        'no_tlp',
        'email',
        'twitter',
        'facebook',
        'instagram',
        'linkedin',
        'youtube',

    ];
}
