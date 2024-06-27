<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berkas;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Storage;

class BerkasController extends Controller
{
    protected $Berkas = [
        'ktp','npwp','swa_photo','slip_gaji','kartu_keluarga'
    ];

    protected $disk = 'local';

    private function cekDir($dir)
    {
        if (!\Storage::disk($this->disk)->exists($dir)) {
            Storage::disk($this->disk)->makeDirectory($dir, 0755, true);
        }
    }

    public function uploadBerkas(Request $request){
        $this->validate($request, [
			'file' => 'required',
			'keterangan' => 'required',
		]);

		// menyimpan data file yang diupload ke variabel $file
		$file = $request->file('file');

      	        // nama file
		echo 'File Name: '.$file->getClientOriginalName();
		echo '<br>';

      	        // ekstensi file
		echo 'File Extension: '.$file->getClientOriginalExtension();
		echo '<br>';

      	        // real path
		echo 'File Real Path: '.$file->getRealPath();
		echo '<br>';

      	        // ukuran file
		echo 'File Size: '.$file->getSize();
		echo '<br>';

      	        // tipe mime
		echo 'File Mime Type: '.$file->getMimeType();

      	        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'data_file';

                // upload file
		$file->move($tujuan_upload,$file->getClientOriginalName());

    }
    public function show($id)
    {
        //find post by ID
        $detail = Berkas::findOrFail($id);

        //return single post as a resource
        return new PostResource(true, 'Data Pemodal', $detail);
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'pemodal_id'      => 'required|exists:pemodal,id',
            'ktp'             => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'npwp'            => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'swa_photo'       => 'file|mimes:jpg,jpeg,png|max:2048',
            'slip_gaji'       => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_keluarga'  => 'file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $paths = [];
        foreach ($this->Berkas as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $extension = $file->getClientOriginalExtension();
                $filename = $field . '.' .  $extension;

                $dir = 'pemodal/' . $request->pemodal_id;
                $this->cekDir($dir);
                Storage::disk($this->disk)->put($dir .'/'. $filename, \File::get($file));

                $paths[$field] = str_replace("/", "&", $dir .'/'. $filename);
            }
        }

        //create pemodal
        $berkas = Berkas::create(array_merge($request->all(), $paths));

        //return response
        return new PostResource(true, 'Berkas Berhasil Ditambahkan!', $berkas);
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'pemodal_id'      => 'required|exists:pemodal,id',
            'ktp'             => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'npwp'            => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'swa_photo'       => 'file|mimes:jpg,jpeg,png|max:2048',
            'slip_gaji'       => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_keluarga'  => 'file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $berkas = Berkas::findOrFail($id);

        $paths = [];
        foreach ($this->Berkas as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $extension = $file->getClientOriginalExtension();
                $filename = $field . '.' .  $extension;

                $dir = 'pemodal/' . $request->pemodal_id;
                $this->cekDir($dir);

                Storage::disk($this->disk)->delete($dir .'/'. $filename);
                Storage::disk($this->disk)->put($dir .'/'. $filename, \File::get($file));

                $paths[$field] = str_replace("/", "&", $dir .'/'. $filename);
            }
        }

        //create post
        $berkas->update([
            'ktp'               => $request->ktp,
            'npwp'              => $request->npwp,
            'swa_photo'         => $request->swa_photo,
            'slip_gaji'         => $request->slip_gaji,
            'kartu_keluarga'    => $request->kartu_keluarga
        ]);

        //return response
        return new PostResource(true, 'Berkas Berhasil Diubah!', $berkas);
    }

    public function destroy($id)
    {
        //find post by ID
        $berkas = Berkas::findOrFail($id);

        //delete file
        foreach (['ktp','npwp','swa_photo','slip_gaji','kartu_keluarga'] as $field) {
            Storage::delete($berkas->$field);
        }

        //delete post
        $berkas->delete();

        //return response
        return new PostResource(true, 'Data Berhasil Dihapus!', null);
    }
}
