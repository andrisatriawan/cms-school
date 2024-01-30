<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('back.profile.index');
        }

        $data = Profile::all();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('content', function ($data) {
                $fullText = $data->content;
                $shortText = substr($fullText, 0, 100);
                $shortText = substr($shortText, 0, strrpos($shortText, ' '));
                $shortText = strip_tags($shortText);
                $shortText = preg_replace('/&\w+;/', '', $shortText);

                return $shortText . '...';
            })
            ->editColumn('photo', function ($data) {
                $fotoPath = public_path('client/profile/' . $data->photo);

                $image = 'Foto belum diupload atau telah dihapus.';

                if (File::exists($fotoPath) && $data->photo != '') {
                    $src = asset('client/profile') . '/' . $data->photo;
                    $image = '<img src="' . $src . '" class="img-thumbnail" style="min-width: 100px;max-width: 180px;" alt="...">';
                }

                return $image;
            })
            ->addColumn('aksi', function ($data) {
                $btn = '<a href="' . route('admin.profile-edit', $data->id) . '" class="action-icon"> <i class="mdi mdi-pencil"></i></a>';
                $btn .= '<a href="#" class="action-icon btn-delete" data-id="' . $data->id . '"> <i class="mdi mdi-delete"></i></a>';

                return $btn;
            })
            ->editColumn('updated_at', function ($data) {
                return tgl_indo($data->updated_at);
            })
            ->rawColumns(['photo', 'aksi'])
            ->make('true');
    }

    public function create()
    {
        return view('back.profile.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal disimpan!',
                'error' => $validator->errors()
            ], 422);
        }

        $fileName = '';

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            if ($file->isValid()) {
                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('client/profile'), $fileName);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal disimpan!',
                    'error' => [
                        'Gagal upload file!'
                    ]
                ], 422);
            }
        }

        $profile = new Profile();

        $order = $profile->latest()->first() != null ? $profile->latest()->first()->order + 1 : 1;

        $profile->slug = $request->input('slug');
        $profile->title = $request->input('title');
        $profile->content = $request->input('content');
        $profile->photo = $fileName;
        $profile->order = $request->input('order') != '' ? $request->input('order') : $order;

        $profile->save();

        return response()->json([
            'status' => true,
            'message' => "Berhasil disimpan",
            'redirect' => route('admin.profile')
        ]);
    }

    public function edit($id)
    {
        $profile = Profile::find($id);

        return view('back.profile.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal disimpan!',
                'error' => $validator->errors()
            ], 422);
        }


        $profile = Profile::findOrFail($id);
        $fileName = $profile->photo;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            if ($profile->photo != '') {
                $oldFotoPath = public_path('client/profile/' . $request->old_foto);

                if (File::exists($oldFotoPath)) {
                    File::delete($oldFotoPath);
                }
            }

            if ($file->isValid()) {
                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('client/profile'), $fileName);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal disimpan!',
                    'error' => [
                        'Gagal upload file!'
                    ]
                ], 422);
            }
        }

        if ($request->delete_foto != "false") {
            $fotoPath = public_path('client/profile/' . $profile->photo);

            if (File::exists($fotoPath)) {
                File::delete($fotoPath);
            }
            $fileName = '';
        }

        $order = $profile->latest()->first() != null ? $profile->latest()->first()->order + 1 : 1;

        $profile->slug = $request->input('slug');
        $profile->title = $request->input('title');
        $profile->content = $request->input('content');
        $profile->photo = $fileName;
        $profile->order = $request->input('order') != '' ? $request->input('order') : $order;

        $profile->save();

        return response()->json([
            'status' => true,
            'message' => "Berhasil diubah",
            'redirect' => route('admin.profile')
        ]);
    }

    public function delete(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Profile gagal dihapus. Data tidak ditemukan!'
            ], 404);
        }

        $oldFotoPath = public_path('client/blog/' . $profile->photo);

        if (File::exists($oldFotoPath) && $profile->photo != '') {
            File::delete($oldFotoPath);
        }

        $profile->delete();

        return response()->json([
            'status' => true,
            'message' => 'Profile berhasil dihapus!'
        ]);
    }
}
