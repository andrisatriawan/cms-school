<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('back.users.index');
        }

        $data = Users::all();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) {
                $btn = '<span class="text-muted small">No Action</small>';

                if (auth()->user()->id != $data->id) {
                    $btn = '<a href="' . route('admin.users-edit', $data->id) . '" class="action-icon"> <i class="mdi mdi-pencil"></i></a>';
                    $btn .= '<a href="#" class="action-icon btn-delete" data-id="' . $data->id . '"> <i class="mdi mdi-delete"></i></a>';
                }

                return $btn;
            })
            ->editColumn('updated_at', function ($data) {
                return tgl_indo($data->updated_at);
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('back.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'j_k' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal disimpan!',
                'error' => $validator->errors()
            ], 422);
        }

        $password = $request->password != '' ? $request->password : '123456';

        $users = new Users();

        $users->name = $request->nama;
        $users->email = $request->email;
        $users->password = Hash::make($password);
        $users->tipe = 'admin';
        $users->tempat_lahir = $request->tempat_lahir;
        $users->tanggal_lahir = $request->tanggal_lahir;
        $users->alamat = $request->alamat;
        $users->j_k = $request->j_k;
        $users->agama = $request->agama;

        $users->save();

        return response()->json([
            'status' => true,
            'message' => 'User berhasil disimpan!',
            'redirect' => route('admin.users')
        ]);
    }

    public function edit($id)
    {
        $user = Users::find($id);
        return view('back.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = Users::findOrFail($id);

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->nama;
        $user->email = $request->email;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->j_k = $request->j_k;
        $user->agama = $request->agama;
        $user->alamat = $request->alamat;

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User berhasil diubah.',
            'redirect' => route('admin.users')
        ]);
    }

    public function delete($id)
    {
        Users::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'User berhasil dihapus.'
        ]);
    }
}
