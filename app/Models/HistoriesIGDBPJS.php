<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriesIGDBPJS extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'mt_histories_igd_bpjs';
    protected $primaryKey = 'kode_kunjungan';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_kunjungan',
        'noAntrian',
        'noMR',
        'noKartu',
        'tglSep',
        'ppkPelayanan',
        'jnsPelayanan',
        'klsRawatHak', 
        'klsRawatNaik', 
        'pembiayaan', 
        'penanggungJawab',
        'asalRujukan',
        'tglRujukan',
        'noRujukan',
        'ppkRujukan',
        'diagAwal',
        'lakaLantas',
        'noLP',
        'tglKejadian',
        'keterangan',
        'kdPropinsi',
        'kdKabupaten',
        'kdKecamatan',
        'dpjpLayan',
        'noTelp',
        'user',
        'response',
        'is_bridging',
        'is_ranap_umum',
        'status_daftar',
        
    ];

    protected $casts = [
        'response' => 'string',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'noMR', 'no_rm');
    } 
    public function dokterJkn()
    {
        return $this->belongsTo(Paramedis::class, 'dpjpLayan', 'kode_dokter_jkn');
    }
    public function icd10()
    {
        return $this->hasOne(Icd10::class, 'diagAwal', 'diag');
    }
   

}
