<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;


class PagesController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {

            return view('back.pages.index');
        }
        $pages = (new Pages())->orderBy('id', 'desc')->get();

        return DataTables::of($pages)
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
                $src = asset('client/page') . '/' . $data->photo;
                $image = '<img src="' . $src . '" class="img-thumbnail" style="min-width: 100px;max-width: 180px;" alt="...">';

                return $image;
            })
            ->addColumn('kategori', function ($data) {

                if ($data->header == '1') {
                    $str = "<span class='badge bg-primary'>Menu Lainnya</span>";
                } elseif ($data->header == '2') {
                    $str = "<span class='badge bg-warning'>Section Layanan</span>";
                } else {
                    $str = '';
                }
                return $str;
            })
            ->addColumn('aksi', function ($data) {
                $btn = '<a href="' . route('admin.pages-edit', $data->id) . '" class="action-icon"> <i class="mdi mdi-pencil"></i></a>';
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
        return view('back.pages.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            // 'deskripsi' => 'required',
            'header' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal disimpan!',
                'error' => $validator->errors()
            ], 422);
        }

        $file = $request->file('foto');
        $fileName = null;
        if ($file) {
            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('client/page'), $fileName);
        }

        $page = new Pages();

        if ($request->input('slug')) {
            $page->slug = $request->input('slug');
        } else {
            $page->slug = Str::slug($request->input('title'));
        }
        $page->title = $request->input('title');
        $page->url = $request->input('url');
        $page->icon = $request->input('icon');
        $page->header = $request->input('header');
        $page->deskripsi = $request->input('deskripsi');
        $page->photo = $fileName;

        $page->save();

        return response()->json([
            'status' => true,
            'message' => "Berhasil disimpan",
            'redirect' => route('admin.pages')
        ]);
    }

    public function edit($id)
    {
        $page = Pages::find($id);

        return view('back.pages.edit', compact('page'));
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

            $oldFotoPath = public_path('client/page/' . $request->old_foto);

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

                $file->move(public_path('client/page'), $fileName);
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

        $page = Pages::findOrFail($id);

        $page->title = $request->input('title');
        $page->url = $request->input('url');
        $page->icon = $request->input('icon');
        $page->header = $request->input('header');
        $page->deskripsi = $request->input('deskripsi');
        $page->photo = $fileName;

        $page->save();

        return response()->json([
            'status' => true,
            'message' => "Berhasil disimpan",
            'redirect' => route('admin.pages')
        ]);
    }

    public function delete(Request $request, $id)
    {
        $page = Pages::findOrFail($id);

        if (!$page) {
            return response()->json([
                'status' => false,
                'message' => 'Page gagal dihapus. Data tidak ditemukan!'
            ], 404);
        }
        $oldFotoPath = public_path('client/page/' . $page->photo);

        if (File::exists($oldFotoPath)) {
            File::delete($oldFotoPath);
        }

        $page->delete();

        return response()->json([
            'status' => true,
            'message' => 'Page berhasil dihapus!'
        ]);
    }
}
