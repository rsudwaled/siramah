<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienKecelakaan extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'ts_pasien_kecelakaan';
    protected $guarded = ["id"];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'kdPropinsi', 'kode_provinsi' );
    }
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kdKabupaten', 'kode_kabupaten_kota' );
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kdKecamatan', 'kode_kecamatan' );
    }
}
