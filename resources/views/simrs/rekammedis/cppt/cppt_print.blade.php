<!DOCTYPE html>
<html>
<head>
	<title>RESUME_DOKTER</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
    body{
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        width: 100%;
    }
    #table-header{
            border-collapse: collapse;
            width: 100%;
        }
    #table-header, #table-header th, #table-header td {
        border: 1px solid black;
    }
    .container{
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .container-assesment{
        padding: 10px;
    }
    .title{
        width: 100%;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        margin-top: 10px
    }
    .title_left{
        font-size: 16px;
        font-weight: bold;
        width: 100%;
        font-size: 16px;
        text-align: left;
    }
    .title_asses{
        color: white;
    }
    .address{
        font-size: 12px;
        text-align: center;
    }
    #tbl_right{
        font-size: 12px;
        border: 0;
        margin: 5px;
    }
    #tbl_right, #tbl_right th, #tbl_right td {
        border: 0;
    }
    #td_right{
        padding-left: 10px;
        border: 0;
    }
    #date_ass{
        font-size: 12px;
        padding: 10px;
    }
    #doc_ass{
        font-size: 12px;
        padding-top: 100px;
        padding-left: 10px;
        text-align: center;

    }
    #gambar_pemeriksaan{
        height: 200px;
        margin: 10px;
        text-align: center;
    }
</style>
<body>
    <table id="table-header">
        <tr>
            <th style="border: 1px solid black;">
                <div class="container">
                    <div class="title">
                        PEMERINTAHAN KABUPATEN CIREBON <br> RUMAH SAKIT UMUM DAERAH WALED
                    </div>
                    <div class="address">
                        Jl. Prabu Kian Santang No. 4 Tlp. 0231-661126 <br> Fax. 0231-664091 Cirebon e-mail : brsud.waled@gmail.com
                    </div>
                </div>
            </td>
            <th>
                <table id="tbl_right">
                    <tr>
                        <td>No RM</td>
                        <td id="td_right">{{$data->NO_RM}}</td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td id="td_right">{{$data->NAMA_PX}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td id="td_right">{{$data->TGL_LAHIR}}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td id="td_right">{{$data->jENIS_KELAMIN}}</td>
                    </tr>
                </table>
            </th>
        </tr>
        <tr>
            <th>
                <div class="container-assesment">
                    <div class="title_left">ASSESMEN AWAL MEDIS RAWAT JALAN MATA (KLINIK)</div>
                </div>
            </td>
            <th >
                <table id="tbl_right">
                    <tr>
                        <td>Tanggal Kunjungan</td>
                        <td id="td_right">{{$data->tgl_kunjungan}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Assesmen</td>
                        <td id="td_right">{{$data->tgl_pemeriksaan}}</td>
                    </tr>
                </table>
            </th>
        </tr>
        {{-- assesmen awal --}}
        <tr>
            <th colspan="2" style="background-color: rgb(253, 36, 3)">
                <div class="container-assesment">
                    <div class="title_asses">Assesmen Awal Medis</div>
                </div>
            </th>
        </tr>
        <tr>
            <td >
                <table id="tbl_right">
                    <tr>
                        <td>Sumber Data</td>
                        <td id="td_right">{{$data->sumber_data}}</td>
                    </tr>
                    <tr>
                        <td>Keluhan Pasien</td>
                        <td id="td_right">Burem</td>
                    </tr>
                    <tr>
                        <td>Tekanan Darah</td>
                        <td id="td_right">{{$data->tekanan_darah}} mmHg</td>
                    </tr>
                    <tr>
                        <td>Frekuensi Nadi</td>
                        <td id="td_right">{{$data->frekuensi_nadi}} x/menit</td>
                    </tr>
                </table>
            </td>
            <td >
                <table id="tbl_right">
                    <tr>
                        <td>Frekuensi Nafas</td>
                        <td id="td_right">{{$data->frekuensi_nafas}}  x/menit</td>
                    </tr>
                    <tr>
                        <td>Suhu Tubuh</td>
                        <td id="td_right">{{$data->suhu_tubuh}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        {{-- Riwayat Kesehatan --}}
        <tr >
            <th colspan="2" style="background-color: rgb(253, 36, 3)">
                <div class="container-assesment">
                    <div class="title_asses">Riwayat Kesehatan</div>
                </div>
            </th>
        </tr>
        <tr>
            <td colspan="2">
                <table id="tbl_right">
                    <tr>
                        <td>Riwayat Kehamilan</td>
                        <td id="td_right">{{$data->riwayat_kehamilan_pasien_wanita == null ? '(bagi pasien perempuan)' : $data->riwayat_kehamilan_pasien_wanita}}</td>
                    </tr>
                    <tr>
                        <td>Riwayat Kelahiran</td>
                        <td id="td_right">{{$data->riwyat_kelahiran_pasien_anak == null ? '(bagi pasien anak)' : $data->riwyat_kelahiran_pasien_anak}}</td>
                    </tr>
                    <tr>
                        <td>Riwayat Penyakit Sekarang</td>
                        <td id="td_right">{{$data->riwyat_penyakit_sekarang == null ? '(Tidak Ada)' : $data->riwyat_penyakit_sekarang}}</td>
                    </tr>
                </table>
            </td>
        </tr>
         {{-- Riwayat Penyakit Dahulu --}}
         <tr >
            <th colspan="2" style="background-color: rgb(253, 36, 3)">
                <div class="container-assesment">
                    <div class="title_asses">Riwayat Penyakit Dahulu</div>
                </div>
            </th>
        </tr>
        <tr>
            <td >
                <table id="tbl_right">
                    <tr>
                        <td>Hipertensi</td>
                        <td id="td_right">{{$data->hipertensi == null ? 'Tidak Ada' : $data->hipertensi}}</td>
                    </tr>
                    <tr>
                        <td>Jantung</td>
                        <td id="td_right">{{$data->jantung == null ? 'Tidak Ada' : $data->jantung}}</td>
                    </tr>
                    <tr>
                        <td>Hipertensi</td>
                        <td id="td_right">{{$data->hipertensi == null ? 'Tidak Ada' : $data->hipertensi}}</td>
                    </tr>
                    <tr>
                        <td>Ginjal</td>
                        <td id="td_right">{{$data->ginjal == null ? 'Tidak Ada' : $data->ginjal}}</td>
                    </tr>
                    <tr>
                        <td>Riwayat Lainnya</td>
                        <td id="td_right">{{$data->riwayatlain == null ? 'Tidak Ada' : $data->riwayatlain}}</td>
                    </tr>
                    <tr>
                        <td>Riwayat Alergi</td>
                        <td id="td_right">{{$data->riwayat_alergi == null ? 'Tidak Ada' : $data->riwayat_alergi}}</td>
                    </tr>
                    <tr>
                        <td>Status Generalis</td>
                        <td id="td_right">{{$data->statusgeneralis == null ? 'Tidak Ada' : $data->statusgeneralis}}</td>
                    </tr>
                </table>
            </td>
            <td >
                <table id="tbl_right">
                    <tr>
                        <td>Kencing Manis</td>
                        <td id="td_right">{{$data->kencingmanis == null ? 'Tidak Ada' : $data->kencingmanis}}</td>
                    </tr>
                    <tr>
                        <td>Stroke</td>
                        <td id="td_right">{{$data->stroke == null ? 'Tidak Ada' : $data->stroke}}</td>
                    </tr>
                    <tr>
                        <td>Asthma</td>
                        <td id="td_right">{{$data->asthma == null ? 'Tidak Ada' : $data->asthma}} </td>
                    </tr>
                    <tr>
                        <td>Tb/Paru</td>
                        <td id="td_right">{{$data->tbparu == null ? 'Tidak Ada' : $data->tbparu}} </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td id="td_right"></td>
                    </tr>
                    <tr>
                        <td>Keterangan Alergi</td>
                        <td id="td_right">{{$data->keterangan_alergi == null ? 'Tidak Ada' : $data->keterangan_alergi}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        {{-- Riwayat Penyakit Dahulu --}}
        <tr >
            <th colspan="2" style="background-color: rgb(253, 36, 3)">
                <div class="container-assesment">
                    <div class="title_asses">Pemeriksaan Fisik</div>
                </div>
            </th>
        </tr>
        <tr>
            <td colspan="2">
                <table id="tbl_right">
                    <tr>
                        <td>Pemeriksaan Fisik</td>
                        <td id="td_right">-</td>
                    </tr>
                </table>
            </td>
        </tr>
        {{-- Pemeriksaan Umum --}}
        <tr >
            <th colspan="2" style="background-color: rgb(253, 36, 3)">
                <div class="container-assesment">
                    <div class="title_asses">Pemeriksaan Umum</div>
                </div>
            </th>
        </tr>
        <tr>
            <td colspan="2">
                <table id="tbl_right">
                    <tr>
                        <td>Keadaan Umum</td>
                        <td id="td_right"></td>
                    </tr>
                    <tr>
                        <td>Kesadaran</td>
                        <td id="td_right">Composmentis</td>
                    </tr>
                    <tr>
                        <td>Diagnosa Kerja</td>
                        <td id="td_right">keratilis od (resolving)</td>
                    </tr>
                    <tr>
                        <td>Diagnosa Branding</td>
                        <td id="td_right"></td>
                    </tr>
                    <tr>
                        <td>Rencana Kerja</td>
                        <td id="td_right">tobrosan ed 6 x OD(habiskan)</td>
                    </tr>
                    <tr>
                        <td>Tindak Lanjut</td>
                        <td id="td_right">KONTROL</td>
                    </tr>
                </table>
            </td>
        </tr>
        {{-- Hasil Pemeriksaan Khusus --}}
        <tr >
            <th colspan="2" style="background-color: rgb(253, 36, 3)">
                <div class="container-assesment">
                    <div class="title_asses">Pemeriksaan Khusus</div>
                </div>
            </th>
        </tr>
        <tr>
            <td colspan="2">
                <table id="tbl_right">
                    <tr>
                        <td>Pemeriksaan Khusus 1</td>
                        <td id="td_right" style="width:90%">{{$data->pemeriksaan_khusus == null ? 'Tidak Ada' : $data->pemeriksaan_khusus}}</td>
                    </tr>
                    <tr>
                        <td>Pemeriksaan Khusus 2</td>
                        <td id="td_right">{{$data->pemeriksaan_khusus_2 == null ? 'Tidak Ada' : $data->pemeriksaan_khusus_2}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th><div class="container-assesment">Tanggal Assesmen</div></th>
            <th><div class="container-assesment">Nama Pemeriksa</div></th>
        </tr>
        <tr>
            <td  id="date_ass">{{$data->tgl_pemeriksaan}}</td>
            <td style="text-align: center"> <label id="doc_ass">{{$data->nama_dokter}}</label></td>
        </tr>
        <tr>
            <th>
                <div class="container-assesment">
                    <div class="title_left">ASSESMEN AWAL MEDIS RAWAT JALAN MATA (KLINIK)</div>
                    <table id="tbl_right">
                        <tr>
                            <td>Tanggal Kunjungan</td>
                            <td id="td_right">{{$data->tgl_kunjungan}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pemeriksaan</td>
                            <td id="td_right">{{$data->tgl_pemeriksaan}}</td>
                        </tr>
                    </table>
                </div>
            </td>
            <th >
                <table id="tbl_right">
                    <tr>
                        <td>No RM</td>
                        <td id="td_right">{{$data->NO_RM}}</td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td id="td_right">{{$data->NAMA_PX}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td id="td_right">{{$data->TGL_LAHIR}}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td id="td_right">{{$data->jENIS_KELAMIN}}</td>
                    </tr>
                </table>
            </th>
        </tr>
        <tr >
            <th colspan="2" style="background-color: rgb(253, 36, 3)">
                <div class="container-assesment">
                    <div class="title_asses">Gambar Pemeriksaan</div>
                </div>
            </th>
        </tr>
        <tr >
           <th colspan="2" id="gambar_pemeriksaan">
            <img src="data:image/gif;base64,' . {{$gambar}} . '" alt="" width="100%" height="400px">
           </th>
        </tr>
    </table>
</body>
</html>
