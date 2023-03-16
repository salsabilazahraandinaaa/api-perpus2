<?php

namespace App\Http\Controllers;

use App\Models\bukuM;
use Illuminate\Http\Request;
use App\Http\Resources\bukuR;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class bukuC extends Controller
{
    public function index()
    {
        $Buku = BukuM::latest()->paginate(5);

        return new BukuR(true, 'List Data Buku', $Buku);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all() , [
            'cover'             => 'required|image|mimes:jpeg,png,jpg,gif,svg,webm',
            'nama_buku'               => 'required',
            'penerbit'               => 'required',
            'jumlah_halaman'               => 'required',
            'summary'               => 'required',
            'qty'               => 'required',
            'tahun_rilis'             => 'required'
        ]); 

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $cover = $request->file('cover');
        $cover->storeAs('public/buku', $cover->hashName());

        $Buku = bukuM::create([
            'cover'         => $cover->hashname(),
            'nama_buku'                 => $request->nama_buku,
            'penerbit'                 => $request->penerbit,
            'jumlah_halaman'                 => $request->jumlah_halaman,
            'summary'                 => $request->summary,
            'qty'                   => $request->qty,
            'tahun_rilis'                 => $request->tahun_rilis,
        ]);

        return new bukuR(true, 'Data Buku Berhasil Ditambahkan', $Buku);
    }

    public function show(bukuM $Buku){
        return new bukuR(true, 'Data Buku Ditemukan', $Buku);
    }

    public function update(Request $request, bukuM $Buku){
        $validator = Validator::make($request->all() , [
            'nama_buku'               => 'required',
            'penerbit'               => 'required',
            'jumlah_halaman'               => 'required',
            'summary'               => 'required',
            'qty'               => 'required',
            'tahun_rilis'             => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('cover')){
            
            $cover = $request->file('cover');
            $cover->storeAs('public/Buku', $cover->hashName());

            Storage::delete('public/Buku/'.$Buku->cover);

            $Buku->update([
                'cover'         => $cover->hashname(),
                'nama_buku'                 => $request->nama_buku,
                'penerbit'                 => $request->penerbit,
                'jumlah_halaman'                 => $request->jumlah_halaman,
                'summary'                 => $request->summary,
                'qty'                   => $request->qty,
                'tahun_liris'                 => $request->tahun_liris,
            ]);

        } else {
            $Buku->update([
                'nama_buku'                 => $request->nama_buku,
                'penerbit'                 => $request->penerbit,
                'jumlah_halaman'                 => $request->jumlah_halaman,
                'summary'                 => $request->summary,
                'qty'                   => $request->qty,
                'tahun_liris'                 => $request->tahun_liris,
            ]);
        }

        return new bukuR(true, 'Data Buku Berhasil Diubah', $Buku);

    }

    public function destroy(bukuM $Buku){
        Storage::delete('public/Buku/'.$Buku->cover);

        $Buku->delete();

        return new bukuR(true, 'Data Buku Berhasil Dihapus', null);
    }
}
