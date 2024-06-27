<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AkunBank;
use Illuminate\Http\Request;
//import Resource "PostResource"
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class AkunBankController extends Controller
{
    public function show($id)
    {
        //find post by ID
        $detail = AkunBank::findOrFail($id);

        //return single post as a resource
        return new PostResource(true, 'Akun Bank Pemodal', $detail);
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'pemodal_id'                        => 'required|exists:pemodal,id',
            'nomer_rekening'                    => 'nullable|string|max:255',
            'nama_pemilik_rekening'             => 'nullable|string|max:255',
            'nama_bank'                         => 'nullable|string|max:255',
            'kabupaten_cabang_bank'             => 'nullable|string|max:255',
            'provinsi_cabang_bank'              => 'nullable|string|max:255',
            'nama_ibu_kandung'                  => 'nullable|string|max:255',
            'nama_ahli_waris'                   => 'nullable|string|max:255',
            'nomor_rekening_custodian'          => 'nullable|string|max:255',
            'nama_rekening_custodian'           => 'nullable|string|max:255',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create pemodal
        $akunbank = AkunBank::create($request->all());

        //return response
        return new PostResource(true, 'Akun Bank Berhasil Ditambahkan!', $akunbank);
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'pemodal_id'                        => 'required|exists:pemodal,id',
            'nomer_rekening'                    => 'nullable|string|max:255',
            'nama_pemilik_rekening'             => 'nullable|string|max:255',
            'nama_bank'                         => 'nullable|string|max:255',
            'kabupaten_cabang_bank'             => 'nullable|string|max:255',
            'provinsi_cabang_bank'              => 'nullable|string|max:255',
            'nama_ibu_kandung'                  => 'nullable|string|max:255',
            'nama_ahli_waris'                   => 'nullable|string|max:255',
            'nomor_rekening_custodian'          => 'nullable|string|max:255',
            'nama_rekening_custodian'           => 'nullable|string|max:255',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $akunBank = AkunBank::findOrFail($id);
        $akunBank->update($request->all());

        return new PostResource(true, 'Data Berhasil Diubah!', $akunBank);
    }

    public function destroy($id)
    {
        //find post by ID
        $akunBank = AkunBank::findOrFail($id);

        //delete image
        // Storage::delete('public/posts/'.basename($post->image));

        //delete post
        $akunBank->delete();

        //return response
        return new PostResource(true, 'Data Berhasil Dihapus!', null);
    }
}
