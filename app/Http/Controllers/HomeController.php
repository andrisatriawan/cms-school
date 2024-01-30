<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Pages;
use App\Models\Profile;
use App\Models\Sliders;
use App\Models\Contacts;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $blogs = Blogs::offset(0)->limit(10)->orderBy('created_at', 'desc')->get();
        $sliders = Sliders::offset(0)->limit(3)->orderBy('created_at', 'desc')->get();
        $pages_menu = Pages::where('header', 1)->get();
        $pages_layanan = Pages::where('header', 2)->get();
        $contacts = Contacts::find(1);

        return view('front.home', compact('blogs', 'sliders', 'contacts', 'pages_menu', 'pages_layanan'));
    }

    public function blogs()
    {
        $blogs = Blogs::orderBy('id', 'desc')->paginate(10);

        return view('front.pages.blogs', compact('blogs'));
    }

    public function article($id)
    {
        $id = base64_decode($id);
        $article = Blogs::find($id);

        if ($article == null) {
            return abort(404);
        }

        return view('front.pages.article', compact('article'));
    }

    public function profile($slug)
    {
        $profile = Profile::where('slug', $slug)->first();

        if ($profile == null) {
            return abort(404);
        }

        return view('front.pages.profile', compact('profile'));
    }

    public function page($slug)
    {
        $page = Pages::where('slug', $slug)->first();

        if ($page == null) {
            return abort(404);
        }

        return view('front.pages.page', compact('page'));
    }
}
