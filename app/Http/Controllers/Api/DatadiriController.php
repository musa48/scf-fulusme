<?php

namespace App\Http\Controllers\Api;

use App\Models\DataDiri;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//import Resource "PostResource"
use App\Http\Resources\PostResource;
//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

class DatadiriController extends Controller
{
    public function index()
    {
        //get all posts
        $datadiri = DataDiri::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Posts', $datadiri);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_depan'        	            => 'required',
            'nama_belakang'                     => 'required',
            'jenis_kelamin'                     => 'required',
            'tempat_lahir'                      => 'required',
            'tanggal_lahir'                     => 'required',
            'no_handphone'                      => 'required',
            'no_ktp'                            => 'required',
            'no_npwp'                           => 'required',
            'no_sid'                            => 'required',
            'agama'                             => 'required',
            'kewarganegaraan'                   => 'required',
            'alamat_ktp'                        => 'required',
            'kelurahan_ktp'                     => 'required',
            'kecamatan_ktp'                     => 'required',
            'kabupaten_ktp'                     => 'required',
            'provinsi_ktp'                      => 'required',
            'alamat_domisili'                   => 'required',
            'kelurahan_domisili'                => 'required',
            'kecamatan_domisili'                => 'required',
            'kabupaten_domisili'                => 'required',
            'provinsi_domisili'                 => 'required',
            'pendidikan_terakhir'               => 'required',
            'pekerjaan'                         => 'required',
            'industri_pekerjaan'                => 'required',
            'pendapatan_per_bulan'              => 'required',
            'sumber_pendapatan'                 => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        // $image = $request->file('image');
        // $image->storeAs('public/posts', $image->hashName());

        //create post
        $pemodal = DataDiri::create([
            'nama_depan'                        => $request->nama_depan,
            'nama_belakang'                     => $request->nama_belakang,
            'jenis_kelamin'                     => $request->jenis_kelamin,
            'tempat_lahir'                      => $request->tempat_lahir,
            'tanggal_lahir'                     => $request->tanggal_lahir,
            'no_handphone'                      => $request->no_handphone,
            'no_ktp'                            => $request->no_ktp,
            'no_npwp'                           => $request->no_npwp,
            'no_sid'                            => $request->no_sid,
            'agama'                             => $request->agama,
            'kewarganegaraan'                   => $request->kewarganegaraan,
            'alamat_ktp'                        => $request->alamat_ktp,
            'kelurahan_ktp'                     => $request->kelurahan_ktp,
            'kecamatan_ktp'                     => $request->kecamatan_ktp,
            'kabupaten_ktp'                     => $request->kabupaten_ktp,
            'provinsi_ktp'                      => $request->provinsi_ktp,
            'alamat_domisili'                   => $request->alamat_domisili,
            'kelurahan_domisili'                => $request->kelurahan_domisili,
            'kecamatan_domisili'                => $request->kecamatan_domisili,
            'kabupaten_domisili'                => $request->kabupaten_domisili,
            'provinsi_domisili'                 => $request->provinsi_domisili,
            'pendidikan_terakhir'               => $request->pendidikan_terakhir,
            'pekerjaan'                         => $request->pekerjaan,
            'industri_pekerjaan'                => $request->industri_pekerjaan,
            'pendapatan_per_bulan'              => $request->pendapatan_per_bulan,
            'sumber_pendapatan'                 => $request->sumber_pendapatan,
            'deskripsi_binis'                   => $request->deskripsi_binis,
            'deskripsi_sumber_pendapatan'       => $request->deskripsi_sumber_pendapatan,
            'sumber_informasi'                  => $request->sumber_informasi
        ]);

        //return response
        return new PostResource(true, 'Data Diri Berhasil Ditambahkan!', $pemodal);
    }

    public function unggah_berkas (Request $request){
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //create post
        $post = Post::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

        //return response
        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }
}
