<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $countBlogs = Blogs::count();
        $countPengaduan = Pengaduan::count();
        $countKunjungan = 0;
        $countKunjunganMonth = 0;

        return view('back.dashboard.index', compact(['countBlogs', 'countPengaduan', 'countKunjungan', 'countKunjunganMonth']));
    }
}
