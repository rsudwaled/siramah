@extends('adminlte::page')

@section('title', 'TRACER PENDAFTARAN')
@section('content_header')
    <div class="alert bg-primary alert-dismissible">
        <h5>
            <i class="fas fa-user-tag"></i>TRACER PENGGUNA PENDAFTARAN IGD : Tanggal {{ now()->format('d-m-Y') }}
        </h5>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <form action="" method="get">
                <div class="row col-lg-12">
                    <div class="col-md-5">
                        <label for="tanggal">PIC Pendaftaran</label>
                        <div class="input-group">
                            <select name="user_pendaftaran" id="user_pendaftaran" class="form-control">
                                @foreach ($userList as $user)
                                    <option value="{{ $user->id }}" {{$request->user_pendaftaran == $user->id?'selected':''}}>{{ strtoupper($user->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-7 row">
                        <div class="col-md-6">
                            <label for="tanggal">Tanggal Awal</label>
                            <div class="input-group">
                                <input id="new-event" type="date" name="start" class="form-control "
                                    value="{{ $request->start ? \Carbon\Carbon::parse($request->start)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                    placeholder="Tanggal Jaga">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal">Tanggal Akhir</label>
                            <div class="input-group">
                                <input id="new-event" type="date" name="end" class="form-control "
                                    value="{{ $request->end ? \Carbon\Carbon::parse($request->end)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                    placeholder="Tanggal Jaga">
                                <div class="input-group-append">
                                    <button id="add-new-event" type="submit" class="btn btn-primary btn-sm withLoad">CARI
                                        DATA</button>
                                </div>
                                <button type="submit"
                                    onclick="javascript: form.action='{{ route('cek-pasien-pulang.export') }}';"
                                    target="_blank" class="btn btn-success btn-sm ml-2 float-right">Export
                                    Excel</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="col-lg-12">
            <div class="row">
                @foreach ($userPendaftaran as $user)
                    @php
                    $start = Carbon\Carbon::parse($request->start)->startOfDay();
                    $end = Carbon\Carbon::parse($request->end)->endOfDay();
                        if ($request->start && $request->end) {
                            $web = \App\Models\Kunjungan::whereBetween('tgl_masuk', [$start, $end])
                                ->where('pic', $user->id_simrs)
                                ->whereNotNull('jp_daftar')
                                ->count();
                            $desktop = \App\Models\Kunjungan::whereBetween('tgl_masuk', [
                                $start,
                                $end,
                            ])
                                ->where('pic', $user->id_simrs)
                                ->whereNull('jp_daftar')
                                ->count();
                            $total = \App\Models\Kunjungan::whereBetween('tgl_masuk', [$start, $end])
                                ->where('pic', $user->id_simrs)
                                ->count();
                        } else {
                            $web = \App\Models\Kunjungan::whereDate('tgl_masuk', now())
                                ->where('pic', $user->id_simrs)
                                ->whereNotNull('jp_daftar')
                                ->count();
                            $desktop = \App\Models\Kunjungan::whereDate('tgl_masuk', now())
                                ->where('pic', $user->id_simrs)
                                ->whereNull('jp_daftar')
                                ->count();
                            $total = \App\Models\Kunjungan::whereDate('tgl_masuk', now())
                                ->where('pic', $user->id_simrs)
                                ->count();
                        }

                    @endphp
                    <div class="col-md-4">
                        <div class="card card-widget">
                            <div
                                class="widget-user-header {{ $web > 0 ? 'bg-success' : ($desktop > 0 ? 'bg-warning' : 'bg-secondary') }}">
                                <h5 class="widget-user-desc text-center">{{ strtoupper($user->name) }}</h5>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">{{ $web }} Pasien</h5>
                                            <span class="description-text">SISTEM WEB</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">{{ $desktop }} Pasien</h5>
                                            <span class="description-text">DESKTOP</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="description-block">
                                            <h5 class="description-header">{{ $total }} Pasien</h5>
                                            <span class="description-text">TOTAL PASIEN</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop

@section('plugins.Select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.TempusDominusBs4', true)
@section('plugins.Sweetalert2', true)
@section('js')
@endsection
