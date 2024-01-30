<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contacts;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ContactsController extends Controller
{


    public function index()
    {
        $id = '1';
        $contact = Contacts::find($id);

        return view('back.contacts.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {


        $blog = Contacts::findOrFail($id);

        $blog->maps = $request->input('maps');
        $blog->alamat = $request->input('alamat');
        $blog->no_telp = $request->input('no_telp');
        $blog->email = $request->input('email');
        $blog->facebook = $request->input('facebook');
        $blog->twitter = $request->input('twitter');
        $blog->instagram = $request->input('instagram');
        $blog->linkedin = $request->input('linkedin');
        $blog->youtube = $request->input('youtube');
        $blog->save();

        return response()->json([
            'status' => true,
            'message' => "Berhasil disimpan",
            'redirect' => route('admin.contacts')
        ]);
    }
}
