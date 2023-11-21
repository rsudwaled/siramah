<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Unit;
use Illuminate\Http\Request;

class LaboratoriumController extends Controller
{
    public function hasillaboratorium(Request $request)
    {
        $kodeunit = '3002';
        $kunjungans = Kunjungan::orderBy('tgl_masuk', 'desc')
            ->whereHas('layanans', function ($query) use ($kodeunit) {
                $query->where('kode_unit', $kodeunit);
            })
            ->with([
                'unit',
                'pasien',
                'layanans', 'layanans.layanan_details',
                'layanans.layanan_details.tarif_detail',
                'layanans.layanan_details.tarif_detail.tarif',
            ])
            ->limit(10)->get();
        $units = Unit::whereIn('kelas_unit', ['2'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        return view('simrs.laboratorium.kunjungan_lab', compact([
            'request',
            'units',
            'kunjungans',
        ]));
    }

    public function create()
    {
        //
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
