<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuratLampiranController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,xlx,csv,png,jpg,jpeg',
        ]);
        $filename = time() . '-' . $request->file->getClientOriginalName();
        $fileurl = asset("storage/file_upload/" . $filename);
        $extension = $request->file->extension();
        SuratLampiran::create([
            'surat_id' => $request->id_surat,
            'jenis_surat' => $request->jenis_surat,
            'filename' => $filename,
            'fileurl' => $fileurl,
            'extension' => $extension,
            'user' => Auth::user()->name,
        ]);
        $request->file->move(public_path('storage/file_upload/'), $filename);
        Alert::success('Success', 'Surat Masuk Berhasil Diinputkan');
        return redirect()->back();
    }
    public function destroy($id)
    {
        $suratlampiran = SuratLampiran::where('surat_id', $id)->get();
        foreach ($suratlampiran as  $item) {
            $path = "/storage/file_upload/" . $item->filename;
            if (File::exists(public_path($path))) {
                File::delete(public_path($path));
            }
            $item->delete();
        }
        Alert::success('Success', 'File Lampiran Surat Masuk Berhasil Dihapus');
        return redirect()->back();
    }
}
