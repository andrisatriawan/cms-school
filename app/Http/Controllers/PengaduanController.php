<?php

namespace App\Http\Controllers;

use App\Mail\PengaduanMail;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('back.pengaduan.index');
        }

        $data = Pengaduan::orderBy('id', 'desc')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('detail_kontak', function ($data) {
                $kontak = "No HP : " . $data->no_hp . '<br>';
                $kontak .= "Email : " . $data->email . '<br>';

                return $kontak;
            })
            ->editColumn('created_at', function ($data) {
                return tgl_indo($data->created_at);
            })
            ->addColumn('aksi', function ($data) {
                $btn = '<a href="' . route('admin.blogs-edit', $data->id) . '" class="action-icon"> <i class="mdi mdi-pencil"></i></a>';
                $btn .= '<a href="#" class="action-icon btn-delete" data-id="' . $data->id . '"> <i class="mdi mdi-delete"></i></a>';

                return $btn;
            })
            ->rawColumns(['detail_kontak', 'aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'isi_pengaduan' => 'required',
            'jenis' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal disimpan!',
                'error' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if ($file->isValid()) {
                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('client/pengaduan'), $fileName);

                $pengaduan = new Pengaduan();

                $pengaduan->kode = Str::random(6);
                $pengaduan->nama = $request->nama;
                $pengaduan->instansi = $request->instansi;
                $pengaduan->no_hp = $request->no_hp;
                $pengaduan->email = $request->email;
                $pengaduan->jenis = $request->jenis;
                $pengaduan->isi_pengaduan = $request->isi_pengaduan;
                $pengaduan->file = $fileName;

                $pengaduan->save();

                $pengaduan = $pengaduan->find($pengaduan->id);

                $obj = [
                    'subject' => 'Pengaduan ' . $request->jenis,
                    'view' => 'mail.pengaduan',
                    'data' => $pengaduan,
                    'file' => public_path('client/pengaduan') . '/' . $fileName
                ];

                Mail::to('satria.citieng@gmail.com')->send(new PengaduanMail($obj));

                return response()->json([
                    'status' => true,
                    'message' => "Pengaduan berhasil dikirim! Cek email secara berkala untuk menerima balasan atau respon kami.",
                    'redirect' => route('pengaduan')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Pengaduan gagal dikirim!',
                    'error' => [
                        'Gagal upload file!'
                    ]
                ], 422);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Pengaduan gagal dikirim!',
                'error' => [
                    'Gagal upload file!'
                ]
            ], 422);
        }
    }

    public function create()
    {
        return view('front.pages.pengaduan');
    }
}
