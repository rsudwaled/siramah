<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderObatHeader extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'ts_layanan_header_order';
    protected $guarded = ["id"];


    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'no_rm', 'no_rm');
    }
    public function unit()
    {
        return $this->hasOne(Unit::class, 'kode_unit', 'kode_unit');
    }
    public function asal_unit()
    {
        return $this->hasOne(Unit::class, 'kode_unit', 'unit_pengirim');
    }
    public function dokter()
    {
        return $this->hasOne(Paramedis::class, 'kode_paramedis', 'dok_kirim');
    }
    public function penjamin()
    {
        return $this->hasOne(Penjamin::class, 'kode_penjamin_simrs', 'kode_penjaminx');
    }
    public function kunjungan()
    {
        return $this->hasOne(Kunjungan::class, 'kode_kunjungan', 'kode_kunjungan');
    }
    public function penjamin_simrs()
    {
        return $this->hasOne(PenjaminSimrs::class, 'kode_penjamin', 'kode_penjaminx');
    }
    public function detail()
    {
        return $this->hasMany(OrderObatDetail::class, 'kode_layanan_header', 'kode_layanan_header');
    }
}
