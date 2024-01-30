<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Sliders;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SlidersController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {

            return view('back.sliders.index');
        }
        $sliders = (new Sliders())->orderBy('id', 'desc')->get();


        return DataTables::of($sliders)
            ->addIndexColumn()
            ->editColumn('desc', function ($data) {
                $fullText = $data->desc;
                $shortText = substr($fullText, 0, 100);
                $shortText = substr($shortText, 0, strrpos($shortText, ' '));
                $shortText = strip_tags($shortText);
                $shortText = preg_replace('/&\w+;/', '', $shortText);

                return ($shortText) ? $shortText . '...' : '';
            })
            ->editColumn('photo', function ($data) {
                $src = asset('client/slider') . '/' . $data->photo;
                $image = '<img src="' . $src . '" class="img-thumbnail" style="min-width: 100px;max-width: 180px;" alt="...">';

                return $image;
            })
            ->editColumn('kategori', function ($data) {
                $str = "";
                if ($data->kategori == '1') {
                    $str = "<span class='badge bg-primary'> Di Home</span>";
                } else {
                    $str = "<span class='badge bg-primary'> Di Login</span>";
                }

                return $str;
            })

            ->addColumn('aksi', function ($data) {
                $btn = '<a href="' . route('admin.sliders-edit', $data->id) . '" class="action-icon"> <i class="mdi mdi-pencil"></i></a>';
                $btn .= '<a href="#" class="action-icon btn-delete" data-id="' . $data->id . '"> <i class="mdi mdi-delete"></i></a>';

                return $btn;
            })
            ->editColumn('updated_at', function ($data) {
                return tgl_indo($data->updated_at);
            })

            ->rawColumns(['photo', 'kategori', 'aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('back.sliders.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal disimpan!',
                'error' => $validator->errors()
            ], 422);
        }
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            if ($file->isValid()) {
                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('client/slider'), $fileName);

                $blog = new Sliders();

                $blog->title = $request->input('title');
                $blog->kategori = $request->input('kategori');
                $blog->url = $request->input('url');
                $blog->desc = $request->input('deskripsi');
                $blog->photo = $fileName;

                $blog->save();

                return response()->json([
                    'status' => true,
                    'message' => "Berhasil disimpan",
                    'redirect' => route('admin.sliders')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal disimpan!',
                    'error' => [
                        'Gagal upload file!'
                    ]
                ], 422);
            }
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

    public function edit($id)
    {
        $slider = Sliders::find($id);

        return view('back.sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal disimpan!',
                'error' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            $oldFotoPath = public_path('client/blog/' . $request->old_foto);

            if (File::exists($oldFotoPath)) {
                File::delete($oldFotoPath);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'File lama tidak ditemukan ' . $oldFotoPath
                ], 400);
            }

            if ($file->isValid()) {
                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('client/blog'), $fileName);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal disimpan!',
                    'error' => [
                        'Gagal upload file!'
                    ]
                ], 422);
            }
        } else {
            $fileName = $request->input('old_foto');
        }

        $blog = Sliders::findOrFail($id);

        $blog->title = $request->input('title');
        $blog->kategori = $request->input('kategori');
        $blog->url = $request->input('url');
        $blog->desc = $request->input('desc');
        $blog->photo = $fileName;

        $blog->save();

        return response()->json([
            'status' => true,
            'message' => "Berhasil disimpan",
            'redirect' => route('admin.sliders')
        ]);
    }

    public function delete(Request $request, $id)
    {
        $blog = Sliders::findOrFail($id);

        if (!$blog) {
            return response()->json([
                'status' => false,
                'message' => 'Blog gagal dihapus. Data tidak ditemukan!'
            ], 404);
        }
        $oldFotoPath = public_path('client/blog/' . $blog->photo);

        if (File::exists($oldFotoPath)) {
            File::delete($oldFotoPath);
        }

        $blog->delete();

        return response()->json([
            'status' => true,
            'message' => 'Blog berhasil dihapus!'
        ]);
    }
}
