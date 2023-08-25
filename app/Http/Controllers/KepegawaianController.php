<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kepegawaian;
use App\Models\TingkatPendidikan;
use App\Models\BidangPegawai;
use App\Models\KebutuhanJurusan;
use App\Imports\PegawaiImport;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class KepegawaianController extends Controller
{
    public function vData(Request $request)
    {
        $tingkat = TingkatPendidikan::get();
        $cari_data = null;
        $id_tingkat =$request->tingkat; 
        if($id_tingkat)
        {
            $data   = Kepegawaian::where('is_pegawai',0)->where('jenjang', $id_tingkat)->get();
            $lk   = $data->where('jenis_kelamin', 'L')->where('is_pegawai',0)->count();
            $pr   = $data->where('jenis_kelamin', 'P')->where('is_pegawai',0)->count();
        }else{
            $data   = Kepegawaian::where('is_pegawai',0)->get();
            $lk   = Kepegawaian::where('jenis_kelamin', 'L')->where('is_pegawai',0)->count();
            $pr   = Kepegawaian::where('jenis_kelamin', 'P')->where('is_pegawai',0)->count();
        }
        return view('simrs.kepeg.datakepeg.indexPegawai', compact('request','data','tingkat','lk','pr','id_tingkat'));
    }

    public function importData(Request $request)
    {
        $data = (new PegawaiImport)->toArray($request->file('file'));
        $inserted = 0;
        $jml_data =0;
        $error = [];
        foreach ($data[0] as $row) {
            $tgl1 = $row['tgl_lahir']           == null ? 'Null': \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_lahir']);
            $tgl2 = $row['tmt_jabatan']         == null ? 'Null': \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tmt_jabatan']);
            $tgl3 = $row['tmt_cpns_kontrak']    == null ? 'Null': \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tmt_cpns_kontrak']);
            $tgl4 = $row['tmt_pns_pt']          == null ? 'Null': \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tmt_pns_pt']);
            $tgl5 = $row['tmt_golru']           == null ? 'Null': \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tmt_golru']);
            // $tgl6 = $row['tgl_str']             == null ? 'Null': \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_str']);
            // $tgl7 = $row['tgl_berlaku_str']     == null ? 'Null': \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_berlaku_str']);
            // $tgl8 = $row['tgl_sip']             == null ? 'Null': \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_sip']);
            // $tgl9 = $row['tgl_berlaku_sip']     == null ? 'Null': \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_berlaku_sip']);
            
            $exist = Kepegawaian::where('nik', $row['nik'])->first();
            // dd($exist);
            if($exist)
            {
                $error = 'NIK : '.$exist->nik.'  sudah terdaftar a.n '.$exist->nama_lengkap;
                Alert::warning('PERHATIAN !!', $error);
                return back();
            }

            
            // validasi dan cek data;
            $jenjang = str_replace(".", "", strtoupper($row['jenjang']));
            $dtingkat =0;
            // dd($jenjang);
            if($jenjang == 'SPK' || $jenjang == 'SMA' || $jenjang == 'SMP' || $jenjang == 'SMK' || $jenjang == 'SLTP' || $jenjang == 'SLTA' || $jenjang == 'SD')
            {
                $dtingkat = 1;
            }else{
                $tingkat = TingkatPendidikan::where('nama_tingkat',$jenjang )->first();
            }
            // dd($row['bidang']);
            $bidang = BidangPegawai::where('nama_bidang',$row['bidang'] )->first();

            // validasi jurusan
            $cek_jurusan = KebutuhanJurusan::where('nama_jurusan',strtolower($row['jurusan']))->first();
            // dd($cek_jurusan);
            if($cek_jurusan)
            {
                if($row['jenis_kelamin'] == 'L')
                {
                    $add = $cek_jurusan->keadaan_lk + 1; 
                    $cek_jurusan->keadaan_lk = $add;
                    $cek_jurusan->update();
                }else{
                    $add = $cek_jurusan->keadaan_pr +1;
                    $cek_jurusan->keadaan_pr = $add;
                    $cek_jurusan->update();
                }
            }
            
            $inserted ++;
            $jml_data ++;
            Kepegawaian::create([
                'id'                => $row['id'],
                'nik'               => $row['nik'],
                'nip'               => $row['nip'],
                'nip_lama'          => $row['nip_lama'],
                'nama_lengkap'      => $row['nama_lengkap'],
                'tempat_lahir'      => $row['tempat_lahir'],
                'tgl_lahir'         => $tgl1,
                'status'            => $row['status'],
                'jenis_kelamin'     => $row['jenis_kelamin'],
                'pangkat'           => $row['pangkat'],
                'jabatan'           => $row['jabatan'],
                'tmt_jabatan'       => $tgl2,
                'tmt_cpns_kontrak'  => $tgl3,
                'tmt_pns_pt'        => $tgl4,
                'eselon'            => $row['eselon'],
                'gol'               => $row['gol'],
                'tmt_golru'         => $tgl5,
                'tahun'             => $row['tahun'],
                'bulan'             => $row['bulan'],
                'jenjang'           => $dtingkat == '1' ? $dtingkat : $tingkat->id_tingkat,
                'jurusan'           => $row['jurusan'],
                'struktural'        => $row['struktural'],
                // 'no_str'            => $row['no_str'],
                // 'tgl_str'           => $tgl6,
                // 'tgl_berlaku_str'   => $tgl7,
                // 'no_sip'            => $row['no_sip'],
                // 'tgl_sip'           => $tgl8,
                // 'tgl_berlaku_sip'   => $tgl9,
                'unit_kerja'            => $row['unit_kerja'],
                'format_pendidikan'     => $row['format_pendidikan'],
                'kode_jabatan_jkn_kt'   => $row['kode_jabatan_jkn_kt'],
                'alamat'                => $row['alamat'],
                'id_bidang'             => $bidang->id ,
                'is_pegawai'            => 0,
            ]);
        }
        Alert::success('Berhasil', 'Data Berhasil diimport sebanyak '.$jml_data.' Data Pegawai Baru');
        return back();
    }

    public function editPegawai($id)
    {
        $data = Kepegawaian::findOrFail($id);
        $pendidikan = TingkatPendidikan::orderBy('id_tingkat', 'desc')->get();
        
        return view('simrs.kepeg.datakepeg.editPegawai', compact('data','pendidikan'));
    }

    public function setStatusPegawai(Request $request, $id)
    {
        // Kepegawaian::where('is_pegawai', 1)->update(['is_pegawai'=>0]);
        $data = Kepegawaian::find($id);
        if($data)
        {   
             // validasi jurusan
             $cek_jurusan = KebutuhanJurusan::where('nama_jurusan',strtolower($data->jurusan))->first();
            //  dd($cek_jurusan);
             if($cek_jurusan)
             {
                 if($data->jenis_kelamin == 'L')
                 {
                     $add = $cek_jurusan->keadaan_lk - 1; 
                     $cek_jurusan->keadaan_lk = $add;
                     $cek_jurusan->update();
                 }else{
                     $add = $cek_jurusan->keadaan_pr - 1;
                     $cek_jurusan->keadaan_pr = $add;
                     $cek_jurusan->update();
                 }
             }
            
            $data->is_pegawai = 1;
            $data->save();
            $success = true;
            $message = "Pegawai Berhasil Di Nonaktifkan";
            
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function pegawaiNonaktif(Request $request)
    {
        $tingkat = TingkatPendidikan::get();
        $cari_data = null;
        $id_tingkat =$request->tingkat; 
        if($id_tingkat)
        {
            $data   = Kepegawaian::where('is_pegawai',1)->where('jenjang', $id_tingkat)->get();
        }else{
            $data   = Kepegawaian::where('is_pegawai',1)->get();
        }
        return view('simrs.kepeg.datakepeg.indexPegawaiNonaktif', compact('request','data','tingkat','id_tingkat'));
    }

    public function setStatusPegawaiAktif(Request $request, $id)
    {
        $data = Kepegawaian::find($id);
        if($data)
        {
            // validasi jurusan
            $cek_jurusan = KebutuhanJurusan::where('nama_jurusan',strtolower($data->jurusan))->first();
            // dd($cek_jurusan);
            if($cek_jurusan)
            {
                if($data->jenis_kelamin == 'L')
                {
                    $add = $cek_jurusan->keadaan_lk + 1; 
                    $cek_jurusan->keadaan_lk = $add;
                    $cek_jurusan->update();
                }else{
                    $add = $cek_jurusan->keadaan_pr + 1;
                    $cek_jurusan->keadaan_pr = $add;
                    $cek_jurusan->update();
                }
            }

            $data->is_pegawai = 0;
            $data->save();
            $success = true;
            $message = "Pegawai Berhasil Di Aktifkan";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

}
