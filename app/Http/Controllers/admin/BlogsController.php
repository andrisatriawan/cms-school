<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use GeoIp2\Database\Reader;
use Jenssegers\Agent\Agent;
use Yajra\DataTables\DataTables;
use GeoIP;
use Illuminate\Support\Str;

class BlogsController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {

            return view('back.blogs.index');
        }
        $blogs = (new Blogs())->orderBy('id', 'desc')->get();

        return DataTables::of($blogs)
            ->addIndexColumn()
            ->editColumn('deskripsi', function ($data) {
                $fullText = $data->deskripsi;
                $shortText = substr($fullText, 0, 100);
                $shortText = substr($shortText, 0, strrpos($shortText, ' '));
                $shortText = strip_tags($shortText);
                $shortText = preg_replace('/&\w+;/', '', $shortText);

                return $shortText . '...';
            })
            ->editColumn('photo', function ($data) {
                $src = asset('client/blog') . '/' . $data->photo;
                $image = '<img src="' . $src . '" class="img-thumbnail" style="min-width: 100px;max-width: 180px;" alt="...">';

                return $image;
            })
            ->addColumn('aksi', function ($data) {
                $btn = '<a href="' . route('admin.blogs-edit', $data->id) . '" class="action-icon"> <i class="mdi mdi-pencil"></i></a>';
                $btn .= '<a href="#" class="action-icon btn-delete" data-id="' . $data->id . '"> <i class="mdi mdi-delete"></i></a>';

                return $btn;
            })
            ->editColumn('updated_at', function ($data) {
                return tgl_indo($data->updated_at);
            })
            ->rawColumns(['photo', 'aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('back.blogs.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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

                $file->move(public_path('client/blog'), $fileName);

                $blog = new Blogs();

                $blog->slug = Str::slug($request->input('title'));
                $blog->title = $request->input('title');
                $blog->deskripsi = $request->input('deskripsi');
                $blog->photo = $fileName;

                $blog->save();

                return response()->json([
                    'status' => true,
                    'message' => "Berhasil disimpan",
                    'redirect' => route('admin.blogs')
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
        $blog = Blogs::find($id);

        return view('back.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'deskripsi' => 'required',
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

        $blog = Blogs::findOrFail($id);

        $blog->slug = Str::slug($request->input('title'));
        $blog->title = $request->input('title');
        $blog->deskripsi = $request->input('deskripsi');
        $blog->photo = $fileName;

        $blog->save();

        return response()->json([
            'status' => true,
            'message' => "Berhasil disimpan",
            'redirect' => route('admin.blogs')
        ]);
    }

    public function delete(Request $request, $id)
    {
        $blog = Blogs::findOrFail($id);

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
