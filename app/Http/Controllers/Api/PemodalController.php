<?php

namespace App\Http\Controllers\Api;

use App\Models\Pemodal;
use App\Models\AkunBank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//import Resource "PostResource"
use App\Http\Resources\PostResource;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

class PemodalController extends Controller
{
    public function index(Request $request)
    {
        $perPage = !empty($request->perpage)?$request->perpage:10;

        $pemodal = Pemodal::with(['akunbank', 'pemodalBerkas'])->paginate($perPage);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Pemodal', $pemodal);
    }

    public function show($id)
    {
        //find post by ID
        $detail = Pemodal::with(['akunbank', 'pemodalBerkas'])->findOrFail($id);

        //return single post as a resource
        return new PostResource(true, 'Detail Data Pemodal', $detail);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'user_id'                           => 'required|integer',
            'nama_depan'        	            => 'nullable|string|max:255',
            'nama_belakang'                     => 'nullable|string|max:255',
            'jenis_kelamin'                     => 'nullable|string|max:50',
            'tempat_lahir'                      => 'nullable|string|max:255',
            'tanggal_lahir'                     => 'nullable|date',
            'no_handphone'                      => 'nullable|string|max:15',
            'no_ktp'                            => 'nullable|string|max:17',
            'no_npwp'                           => 'nullable|string|max:30',
            'no_sid'                            => 'nullable|string|max:255',
            'agama'                             => 'nullable|string|max:255',
            'kewarganegaraan'                   => 'nullable|string|max:255',
            'alamat_ktp'                        => 'nullable|string|max:255',
            'kelurahan_ktp'                     => 'nullable|string|max:255',
            'kecamatan_ktp'                     => 'nullable|string|max:255',
            'kabupaten_ktp'                     => 'nullable|string|max:255',
            'provinsi_ktp'                      => 'nullable|string|max:255',
            'alamat_domisili'                   => 'nullable|string|max:255',
            'kelurahan_domisili'                => 'nullable|string|max:255',
            'kecamatan_domisili'                => 'nullable|string|max:255',
            'kabupaten_domisili'                => 'nullable|string|max:255',
            'provinsi_domisili'                 => 'nullable|string|max:255',
            'pendidikan_terakhir'               => 'nullable|string|max:255',
            'pekerjaan'                         => 'nullable|string|max:255',
            'industri_pekerjaan'                => 'nullable|string|max:255',
            'pendapatan_per_bulan'              => 'nullable|string|max:255',
            'sumber_pendapatan'                 => 'nullable|string|max:255',
            'deskripsi_bisnis'                  => 'nullable|string|max:255',
            'deskripsi_sumber_pendapatan'       => 'nullable|string|max:255',

        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create pemodal
        $pemodal = Pemodal::create($request->all());

        //return response
        return new PostResource(true, 'Data Pemodal Berhasil Ditambahkan!', $pemodal);
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'user_id'                           => 'required|integer',
            'nama_depan'        	            => 'nullable|string|max:255',
            'nama_belakang'                     => 'nullable|string|max:255',
            'jenis_kelamin'                     => 'nullable|string|max:50',
            'tempat_lahir'                      => 'nullable|string|max:255',
            'tanggal_lahir'                     => 'nullable|date',
            'no_handphone'                      => 'nullable|string|max:15',
            'no_ktp'                            => 'nullable|string|max:17',
            'no_npwp'                           => 'nullable|string|max:30',
            'no_sid'                            => 'nullable|string|max:255',
            'agama'                             => 'nullable|string|max:255',
            'kewarganegaraan'                   => 'nullable|string|max:255',
            'alamat_ktp'                        => 'nullable|string|max:255',
            'kelurahan_ktp'                     => 'nullable|string|max:255',
            'kecamatan_ktp'                     => 'nullable|string|max:255',
            'kabupaten_ktp'                     => 'nullable|string|max:255',
            'provinsi_ktp'                      => 'nullable|string|max:255',
            'alamat_domisili'                   => 'nullable|string|max:255',
            'kelurahan_domisili'                => 'nullable|string|max:255',
            'kecamatan_domisili'                => 'nullable|string|max:255',
            'kabupaten_domisili'                => 'nullable|string|max:255',
            'provinsi_domisili'                 => 'nullable|string|max:255',
            'pendidikan_terakhir'               => 'nullable|string|max:255',
            'pekerjaan'                         => 'nullable|string|max:255',
            'industri_pekerjaan'                => 'nullable|string|max:255',
            'pendapatan_per_bulan'              => 'nullable|string|max:255',
            'sumber_pendapatan'                 => 'nullable|string|max:255',
            'deskripsi_bisnis'                  => 'nullable|string|max:255',
            'deskripsi_sumber_pendapatan'       => 'nullable|string|max:255',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pemodal = Pemodal::findOrFail($id);
        $pemodal->update($request->all());

        return new PostResource(true, 'Data Berhasil Diubah!', $pemodal);

    }

    public function destroy($id)
    {
        //find post by ID
        $pemodal = Pemodal::findOrFail($id);

        //delete image
        // Storage::delete('public/posts/'.basename($post->image));

        //delete post
        $pemodal->delete();

        //return response
        return new PostResource(true, 'Data Berhasil Dihapus!', null);
    }
}
