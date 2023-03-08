<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Exception;

class MahasiswaController extends Controller
{

    /**
    * @group Mahasiswa
    */
    public function index()
    {
        $data = Mahasiswa::all();
        return ApiFormatter::createApi($data, 'Data Mahasiswa', 200);
    }

    public function create()
    {
        //
    }

    /**
     * @group Mahasiswa
     * @queryParam nama string required Nama Mahasiswa
     * @queryParam nim int required NIM Mahasiswa
     * @queryParam jurusan string required Jurusan Mahasiswa
     */
    public function store(Request $request)
    {
        try{
            $request -> validate([
                'nama' => 'required',
                'nim' => 'required',
                'jurusan' => 'required',
            ]);

            $mahasiswa = Mahasiswa::create([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'jurusan' => $request->jurusan,
            ]);

            $data = Mahasiswa::where('id', '=', $mahasiswa->id)->get();
            if($data){
                return ApiFormatter::createApi($data, 'Data Mahasiswa Berhasil Ditambahkan', 200);
            }
            else{
                return ApiFormatter::createApi(null, 'Data Mahasiswa Gagal Ditambahkan', 400);
            }
        }
        catch(Exception $e){
            return ApiFormatter::createApi(null, $e->getMessage(), 400);
        }

    }

    /**
     * @group Mahasiswa
     * @urlParam id int required ID Mahasiswa . Example: 2
     */
    public function show(string $id)
    {
        $data = Mahasiswa::where('id', '=', $id)->get();

        if($data){
            return ApiFormatter::createApi($data, 'Data Mahasiswa Berhasil Ditampilkan', 200);
        }
        else{
            return ApiFormatter::createApi(null, 'Data Mahasiswa Gagal Ditampilkan', 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * @group Mahasiswa
     * @urlParam id int required ID Mahasiswa
     */
    public function update(Request $request, string $id)
    {
        try{
            $request -> validate([
                'nama' => 'required',
                'nim' => 'required',
                'jurusan' => 'required',
            ]);

            $mahasiswa = Mahasiswa::FindOrFail($id);

            $mahasiswa -> update([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'jurusan' => $request->jurusan,
            ]);

            $data = Mahasiswa::where('id', '=', $mahasiswa->id)->get();
            if($data){
                return ApiFormatter::createApi($data, 'Data Mahasiswa Berhasil Ditambahkan', 200);
            }
            else{
                return ApiFormatter::createApi(null, 'Data Mahasiswa Gagal Ditambahkan', 400);
            }
        }
        catch(Exception $e){
            return ApiFormatter::createApi(null, $e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::FindOrFail($id);

        $data = $mahasiswa->delete();

        if($data){
            return ApiFormatter::createApi(null, 'Data Mahasiswa Berhasil Dihapus', 200);
        }
        else{
            return ApiFormatter::createApi(null, 'Data Mahasiswa Gagal Dihapus', 400);
        }
    }
}


