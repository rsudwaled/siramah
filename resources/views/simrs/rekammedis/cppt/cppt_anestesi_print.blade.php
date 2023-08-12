<!DOCTYPE html>
<html>
<head>
	<title>RESUME_DOKTER_ANESTESI</title>
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
        padding-left: 9px;
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
        color: rgb(5, 4, 4);
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
        font-weight: bold;
        font-size: 12px;
        padding-top: 80px;
        padding-left: 10px;
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
            </th>
            <th>
                <table id="tbl_right">
                    <tr>
                        <td>No RM</td>
                        <td id="td_right">{{$ass[0]->id_pasien}}</td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td id="td_right">{{$ass[0]->pasien->no_rm}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td id="td_right">{{$ass[0]->pasien->tgl_lahir}}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td id="td_right">{{$ass[0]->pasien->jenis_kelamin == 'P' ? 'Perempuan' :'Laki-Laki'}}</td>
                    </tr>
                </table>
            </th>
        </tr>
        <tr>
            <th colspan="2">
                <div class="container-assesment">
                    <div class="title_left">ASSESMEN PRA ANESTESI H-2</div>
                </div>
            </th>
        </tr>
        <tr>
            <th colspan="2">
                <table id="tbl_right">
                    <tr>
                        <td>Sumber Data</td>
                        <td >:</td>
                        <td >{{$ass[0]->sumber_data}}</td>
                    </tr>
                    <tr>
                        <td>Tindakan</td>
                        <td >:</td>
                        <td >{{$ass[0]->tindakanmedis==null? '-' : $ass[0]->tindakanmedis}}</td>
                    </tr>

                </table>
            </th>
        </tr>
        <tr>
            <th colspan="2" style="background-color: rgb(109, 201, 175)">
                <div class="container-assesment">
                    <div class="title_asses">PEMERIKSAAN TANDA VITAL</div>
                </div>
            </th>
        </tr>
        <tr>
            <td>
                <table id="tbl_right">
                    <tr>
                        <td>Kesadaran</td>
                        <td >:</td>
                        <td >{{$ass[0]->kesadaran==null? '-': $ass[0]->kesadaran}}</td>
                    </tr>
                    <tr>
                        <td>Tekanan Darah</td>
                        <td >:</td>
                        <td >{{$ass[0]->tekanan_darah}} mmHg</td>
                    </tr>
                    <tr>
                        <td>Nadi</td>
                        <td >:</td>
                        <td >{{$ass[0]->frekuensi_nadi}} x/menit</td>
                    </tr>
                </table>
            </td>
            <td>
                <table id="tbl_right">
                    <tr>
                        <td>GSC</td>
                        <td >:</td>
                        <td >{{$ass[0]->frekuensi_nadi}}</td>
                    </tr>
                    <tr>
                        <td>Pernafasan</td>
                        <td >:</td>
                        <td >{{$ass[0]->frekuensi_nafas}} Kali/menit</td>
                    </tr>
                    <tr>
                        <td>Suhu</td>
                        <td >:</td>
                        <td >{{$ass[0]->suhu_tubuh}} (°C)</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th colspan="2">
                <div class="container-assesment">
                    <div class="title_left">ANAMNESA</div>
                </div>
            </th>
        </tr>
        <tr>
            <th colspan="2">
                <table id="tbl_right">
                    <tr>
                        <td>Alergi</td>
                        <td >:</td>
                        <td >{{$ass[0]->alergi}}</td>
                    </tr>
                    <tr>
                        <td>Medikasi</td>
                        <td >:</td>
                        <td >{{$ass[0]->medikasi}}</td>
                    </tr>
                    <tr>
                        <td>Post Lines</td>
                        <td >:</td>
                        <td >{{$ass[0]->postillnes}}</td>
                    </tr>
                    <tr>
                        <td>Last Meal</td>
                        <td >:</td>
                        <td >{{$ass[0]->lastmeal == null ? '-': $ass[0]->lastmeal}}</td>
                    </tr>
                    <tr>
                        <td>Event</td>
                        <td >:</td>
                        <td >{{$ass[0]->event}}</td>
                    </tr>
                </table>
            </th>
        </tr>
        <tr>
            <th colspan="2">
                <div class="container-assesment">
                    <div class="title_left">PEMERIKSAAN FISIK</div>
                </div>
            </th>
        </tr>
        <tr>
            <th colspan="2">
                <table id="tbl_right">
                    <tr>
                        <td>Cor</td>
                        <td >:</td>
                        <td >{{$ass[0]->cor}}<td>
                    </tr>
                    <tr>
                        <td>Pulmo</td>
                        <td >:</td>
                        <td >{{$ass[0]->pulmo}}<td>
                    </tr>
                    <tr>
                        <td>Gigi</td>
                        <td >:</td>
                        <td >{{$ass[0]->gigi}}<td>
                    </tr>
                    <tr>
                        <td>Extrimitas</td>
                        <td >:</td>
                        <td >{{$ass[0]->ekstremitas}}<td>
                    </tr>
                </table>
            </th>
        </tr>
        <tr>
            <th colspan="2">
                <div class="container-assesment">
                    <div class="title_left">PENILAIAN EVALUASI JALAN NAFAS</div>
                </div>
            </th>
        </tr>
        <tr>
            <th colspan="2">
                <table id="tbl_right">
                    <tr>
                        <td>L</td>
                        <td >:</td>
                        <td >{{$lemon== null ? '-': $lemon[0]}}</td>
                    </tr>
                    <tr>
                        <td>E</td>
                        <td >:</td>
                        <td >{{$lemon== null ? '-': $lemon[1]}}</td>
                    </tr>
                    <tr>
                        <td>M</td>
                        <td >:</td>
                        <td >{{$lemon== null ? '-': $lemon[2]}}</td>
                    </tr>
                    <tr>
                        <td>O</td>
                        <td >:</td>
                        <td >{{$lemon== null ? '-': $lemon[3]}}</td>
                    </tr>
                    <tr>
                        <td>N</td>
                        <td >:</td>
                        <td >{{$lemon== null ? '-': $lemon[4]}}</td>
                    </tr>
                </table>
            </th>
        </tr>

        <tr>
            <th colspan="2">
                <div class="container-assesment">
                    <div class="title_left">ASSESMEN</div>
                </div>
            </th>
        </tr>
        <tr>
            <th colspan="2">
                <table id="tbl_right">
                    @if ($ass[0]->tindak_lanjut == 1)
                    <tr>
                        <td>Setuju dijadwalkan untuk operasi</td>
                    </tr>
                    @else
                    <tr>
                        <td>Saat ini keadaan pasien dalam kondisi belum optimal untuk dilakukan tindakan anestesi</td>
                    </tr>
                    @endif
                </table>
            </th>
        </tr>
        <tr>
            <th colspan="2">
                <div class="container-assesment">
                    <div class="title_left">SARAN</div>
                </div>
            </th>
        </tr>
        <tr>
            <th colspan="2">
                <table id="tbl_right">
                    <tr>
                        <td>{{$ass[0]->keterangan_tindak_lanjut}}</td>
                    </tr>
                </table>
            </th>
        </tr>
        {{-- TTD --}}
        <tr>
            <td></td>
            <td id="tbl_ttd">
                <table  id="tbl_right">
                    {{-- <tr>
                        <td >Cirebon, 08 Agustus 2023 </td>
                    </tr>
                    <tr>
                        <td>Dokter Anestesi</td>
                    </tr> --}}
                    <tr>
                        <td ><label id="doc_ass">{{$ass[0]->nama_dokter}}</label></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
