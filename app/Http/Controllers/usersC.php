<?php

namespace App\Http\Controllers;

use App\Models\usersM;
use Illuminate\Http\Request;
use App\Http\Resources\usersR;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class usersC extends Controller
{
    public function index()
    {
        $user =usersM::latest()->paginate(5);

        return new usersR(true, 'List Data users', $user);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all() , [
            'username'           => 'required',
            'password'           => 'required',
            'nama_user'          => 'required',
            'role'               => 'required',
            'no_hp'              => 'required'
        ]); 

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user = usersM::create([
            'username'         => $request->username,
            'password'                 => Hash::make($request->password),
            'nama_user'                 => $request->nama_user,
            'role'                 => $request->role,
            'no_hp'                 => $request->no_hp,
        ]);

        return new usersR(true, 'Data users Berhasil Ditambahkan', $user);
    }

    public function show(usersM $user){
        return new usersR(true, 'Data users Ditemukan', $user);
    }

    public function update(Request $request, usersM $user){
        $validator = Validator::make($request->all() , [
            'username'             => 'required',
            'password'               => 'required',
            'nama_user'               => 'required',
            'role'               => 'required',
            'no_hp'               => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }


            Storage::delete('public/users/'.$user->username);

            $user->update([
                'username'         => $request->username,
                'password'                 => Hash::make($request->password),
                'nama_user'                 => $request->nama_user,
                'role'                 => $request->role,
                'no_hp'                 => $request->no_hp,
            ]);

        return new usersR(true, 'Data users Berhasil Diubah', $user);

    }

    public function destroy(usersM $user){
        Storage::delete('public/user/'.$user->username);

        $user->delete();

        return new usersR(true, 'Data User Berhasil Dihapus', null);
    }
}
