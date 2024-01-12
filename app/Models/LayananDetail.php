<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananDetail extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'ts_layanan_detail';
    protected $guarded = ['id'];


    public function tarif_detail()
    {
        return $this->hasOne(TarifLayananDetail::class, 'KODE_TARIF_DETAIL', 'kode_tarif_detail');
    }
    public function barang()
    {
        return $this->hasOne(Barang::class, 'kode_barang', 'kode_barang');
    }
}
