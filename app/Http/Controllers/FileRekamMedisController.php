<?php

namespace App\Http\Controllers;

use App\Models\FileRekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class FileRekamMedisController extends APIController
{
    public function index(Request $request)
    {
        if (empty($request->search)) {
            $filerm = FileRekamMedis::latest()->paginate(20);
        } else {
            $filerm = FileRekamMedis::latest()
                ->where('norm', 'LIKE', '%' . $request->search . '%')
                ->orWhere('nama', 'LIKE', "%{$request->search}%")
                ->paginate(20);
        }
        return view('simrs.rekammedis.efile_index', compact([
            'filerm',
            'request',
        ]));
    }
    public function create()
    {
        // $file = "2022-10-11_15-57-18.884.tif";
        // $im = new Imagick($file);
        // $im->setImageFormat('PNG');
        // $format = $im->getImageFormat();
        // dd($format);
        // $im_blob =  $im->getImagesBlob();
        // dd($im_blob);
        // echo '<img src="data:image/jpg;base64,' . base64_encode($im_blob) . '" />';
        return view('simrs.rekammedis.scanfile');
    }
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "norm" => "required|numeric",
            "nama" => "required",
            // "nomorkartu" => "required|numeric|digits:13",
            // "nik" => "required|numeric|digits:16",
            // "nohp" => "required|numeric",
            // "tanggallahir" => "required",
            "jenisberkas" => "required",
            "namafile" => "required",
            "tanggalscan" => "required",
            "fileurl" => "required",
        ]);
        if ($validator->fails()) {
            return response($validator->errors()->first(), 400);
        }
        try {
            FileRekamMedis::create([
                'norm' => $request->norm,
                'nama' => $request->nama,
                'nomorkartu' => $request->nomorkartu,
                'nik' => $request->nik,
                'nohp' => $request->nohp,
                'tanggallahir' => $request->tanggallahir,
                'jenisberkas' => $request->jenisberkas,
                'namafile' => $request->namafile,
                'tanggalscan' => $request->tanggalscan,
                'fileurl' => $request->fileurl,
            ]);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 400);
        }
        // return redirect()->route('efilerm.index');
        return response()->json('Ok', 200);
    }

    public function show($id)
    {
        $filerm = FileRekamMedis::find($id);
        return response()->json($filerm);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $filerm = FileRekamMedis::find($id);
        $filerm->delete();
        Alert::success('Ok', 'File berhasil dihapus');
        return back();
    }
}
