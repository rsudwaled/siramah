<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EklaimController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }
    public function laporan_eklaim_ranap(Request $request)
    {
        $kunjungans = null;
        if ($request->tanggal) {
            $request['tgl_akhir'] = Carbon::parse($request->tanggal)->startOfDay();
            $kunjungans = Kunjungan::whereRelation('unit', 'kelas_unit', '=', 2)
                ->whereDate('tgl_keluar',  $request->tgl_akhir)
                ->with(['pasien', 'budget', 'tagihan', 'unit', 'status'])
                ->get();
        }
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        return view('casemix.laporan_eklaim_ranap', compact([
            'request',
            'units',
            'kunjungans',
        ]));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
