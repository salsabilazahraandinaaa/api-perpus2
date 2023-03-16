<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanM;
use Illuminate\Http\Request;
use App\Http\Resources\PeminjamanR;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class peminjamanC extends Controller
{
    public function index()
    {
        $Peminjaman = peminjamanM::latest()->paginate(5);

        return new peminjamanR(true, 'List Data Peminjaman', $Peminjaman);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all() , [
            'id_buku'             => 'required',
            'id_user'               => 'required',
            'tanggal_pinjam'               => 'required',
            'tanggal_kembali'               => 'required',
            'denda'               => 'required'
        ]); 

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $Peminjaman = peminjamanM::create([
            'id_buku'         => $request->id_buku,
            'id_user'                 => $request->id_user,
            'tanggal_pinjam'                 => $request->tanggal_pinjam,
            'tanggal_kembali'                 => $request->tanggal_kembali,
            'denda'                 => $request->denda,
        ]);

        return new peminjamanR(true, 'Data Peminjaman Berhasil Ditambahkan', $Peminjaman);
    }

    public function show(peminjamanM $Peminjaman){
        return new peminjamanR(true, 'Data Peminjaman Ditemukan', $Peminjaman);
    }

    public function update(Request $request, peminjamanM $Peminjaman){
        $validator = Validator::make($request->all() , [
            'id_buku'             => 'required',
            'id_user'               => 'required',
            'tanggal_pinjam'               => 'required',
            'tanggal_kembali'               => 'required',
            'denda'               => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

            Storage::delete('public/Peminjaman/'.$Peminjaman->id_user);

            $Peminjaman->update([
                'id_buku'         => $request->id_buku,
                'id_user'                 => $request->id_user,
                'tanggal_pinjam'                 => $request->tanggal_pinjam,
                'tanggal_kembali'                 => $request->tanggal_kembali,
                'denda'                 => $request->denda,
            ]);

        return new peminjamanR(true, 'Data Peminjaman Berhasil Diubah', $Peminjaman);

    }

    public function destroy(peminjamanM $Peminjaman){
        Storage::delete('public/Peminjaman/'.$Peminjaman->id_user);

        $Peminjaman->delete();

        return new peminjamanR(true, 'Data Peminjaman Berhasil Dihapus', null);
    }
}
