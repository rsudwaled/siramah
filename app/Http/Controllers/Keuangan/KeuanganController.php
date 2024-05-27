<?php

namespace App\Http\Controllers\Keuangan;

use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paramedis;
use App\Models\SalaryDoctor;
use App\Models\SalaryDoctorDetail;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $from       = $request->from == null ? now()->format('Y-m-d') : $request->from;
        $to         = $request->to == null ? now()->format('Y-m-d') : $request->to;

        $paramedis  = Paramedis::get();
        $dokterFind = Paramedis::where('kode_paramedis', $request->kode_paramedis)->first();
        if(empty($dokterFind))
        {
            Alert::warning('INFORMASI!', 'kode paramedis tidak terdaftar');
        }
        $findReport = null;
        if (!empty($from) && !empty($to) && !empty($dokterFind)) {
            $findReport = $dokterFind == null ? '' : \DB::connection('mysql2')->select("CALL `SP_LAPORAN_PENDAPATAN_PELAYANAN_1`('$from','$to','$dokterFind->nama_paramedis')");
        }
        
        return view('simrs.keuangan.index',compact('paramedis','findReport','from','to','dokterFind'));
    }

    public function copyTable(Request $request)
    {
        $rowId = $request->input('selectedRowIds');
        $dokterFind = Paramedis::where('kode_paramedis', $request->kode_paramedis)->first();
        if (empty($dokterFind)) {
            return response()->json(['code' => 400]);
        }
        $data = \DB::connection('mysql2')->select("CALL `SP_LAPORAN_PENDAPATAN_PELAYANAN_1`('$request->from','$request->to','$dokterFind->nama_paramedis')");
        $dataCollection = collect($data);
        $dataFiltered = $dataCollection->whereIn('JS', $rowId)->all();
       
        if (empty($dataFiltered)) {
            return response()->json(['code' => 400]);
        }
        
        $salary = new  SalaryDoctor();
        $salary->tanggal_start  = $request->from;
        $salary->tanggal_finish = $request->to;
        $salary->totalVisit     = $request->totalVisit;
        $salary->totalSalary    = $request->totalSalary;
        $salary->status_salary  = 'riview';
        $salary->code_paramedis = $request->kode_paramedis;
        $salary->doctor         = $dokterFind->nama_paramedis;
        if ($salary->save()) {
            foreach ($dataFiltered as $copydata) {
                $detail = new SalaryDoctorDetail();
                $detail->id_layanan_detail  = $copydata->JS;
                $detail->id_salary_doctor   = $salary->id;
                $detail->pelayan            = $copydata->ket;
                $detail->rm                 = $copydata->rm;
                $detail->nama_pasien        = $copydata->NAMA_PX;
                $detail->kode_unit          = $copydata->kode_unit;
                $detail->unit               = $copydata->NAMA_UNIT;
                $detail->kelompok           = $copydata->KELOMPOK;
                $detail->tanggal            = $copydata->TGL;
                $detail->nama_tarif         = $copydata->NAMA_TARIF;
                $detail->jumlah_visit       = $copydata->jumlah_layanan;
                $detail->salary_pervisit    = $copydata->grantotal_layanan;
                $detail->cara_bayar         = $copydata->CARA_BAYAR;
                $detail->nama_penjamin      = $copydata->NAMA_PENJAMIN;
                $detail->save();
            }
        }
        return response()->json(['code' => 200]);
    }
}
