<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kepegawaian extends Model
{
    use HasFactory;
    protected $connection = 'mysql7';
    protected $table = 'mt_pegawai_new';
    protected $guarded = ["id"];
    protected $fillable = [
        'id'               ,
        'nik'              ,
        'nip'              ,
        'nip_lama'         ,
        'nama_lengkap'     ,
        'tempat_lahir'     ,
        'tgl_lahir'        ,
        'status'           ,
        'jenis_kelamin'    ,
        'pangkat'          ,
        'jabatan'          ,
        'tmt_jabatan'      ,
        'tmt_cpns_kontrak' ,
        'tmt_pns_pt'       ,
        'eselon'           ,
        'gol'              ,
        'tmt_golru'        ,
        'tahun'            ,
        'bulan'            ,
        'jenjang'          ,
        'jurusan'          ,
        'struktural'       ,
        'no_str'           ,
        'tgl_str'          ,
        'tgl_berlaku_str'  ,
        'no_sip'           ,
        'tgl_sip'          ,
        'tgl_berlaku_sip'  ,
        'unit_kerja'       ,
        'format_pendidikan',
        'kode_jabatan_jkn_kt',
        'alamat'           ,
        'id_bidang'           ,
    ];

    public function sPendidikan()
    {
        return $this->belongsTo(TingkatPendidikan::class,'jenjang','id_tingkat');
    }
    public function bidang()
    {
        return $this->belongsTo(BidangPegawai::class, 'id_bidang', 'id');
    }
}
