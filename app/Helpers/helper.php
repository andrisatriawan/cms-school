<?php

use App\Models\Contacts;
use App\Models\Pages;
use App\Models\Profile;
use Carbon\Carbon;

function tgl_indo($tgl, $format = 'dddd, D MMMM Y')
{
    $tgl = Carbon::create($tgl);
    return $tgl->isoFormat($format);
}

function lastUpdate($tanggal)
{
    $articleDate = Carbon::parse($tanggal);

    $now = Carbon::now();

    $diff = $articleDate->diffInSeconds($now);

    $formattedDate = $articleDate->isoFormat('dddd, D MMMM Y');

    if ($diff >= 2628000) {
        $timeLabel = $formattedDate;
    } else {
        $timeLabel = $articleDate->diffForHumans($now);
    }

    return $timeLabel;
}

function navProfile()
{
    $profiles = Profile::all();

    return $profiles;
}

function navLainnya()
{
    $lainnya = Pages::where('header', 1)->get();

    return $lainnya;
}

function contacts()
{
    return Contacts::find(1);
}
