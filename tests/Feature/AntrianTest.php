<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class AntrianTest extends TestCase
{
    /**
     * @test
     */
    public function ref_poli(): void
    {
        $response = $this->get(route('ref_poli'));
        $response->assertStatus($response->getData()->metadata->code);
    }
    /**
     * @test
     */
    public function ref_dokter(): void
    {
        $response = $this->get(route('ref_dokter'));
        $response->assertStatus($response->getData()->metadata->code);
    }
    /**
     * @test
     */
    public function ref_jadwal_dokter(): void
    {
        $response = $this->get(route('ref_jadwal_dokter') . '?kodepoli=INT&tanggal=' . now()->format('Y-m-d'));
        $response->assertStatus($response->getData()->metadata->code);
    }
    /**
     * @test
     */
    public function ref_poli_fingerprint(): void
    {
        $response = $this->get(route('ref_poli_fingerprint'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function ref_pasien_fingerprint(): void
    {
        $response = $this->get(route('ref_pasien_fingerprint') . '?noIdentitas=0000067026778&jenisIdentitas=noka');
        $response->assertStatus($response->getData()->metadata->code);
    }
    /**
     * @test
     */
    public function tambah_antrean(): void
    {
        $response = $this->post(route('tambah_antrean'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function tambah_antrean_farmasi(): void
    {
        $response = $this->post(route('tambah_antrean_farmasi'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function update_antrean(): void
    {
        $response = $this->post(route('update_antrean'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function batal_antrean(): void
    {
        $response = $this->post(route('batal_antrean'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function taskid_antrean(): void
    {
        $response = $this->post(route('taskid_antrean'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function dashboard_tanggal(): void
    {
        $response = $this->get(route('dashboard_tanggal'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function dashboard_bulan(): void
    {
        $response = $this->get(route('dashboard_bulan'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function antrian_tanggal(): void
    {
        $response = $this->get(route('antrian_tanggal'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function antrian_kodebooking(): void
    {
        $response = $this->get(route('antrian_kodebooking'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function antrian_pendaftaran(): void
    {
        $response = $this->get(route('antrian_pendaftaran'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function antrian_poliklinik(): void
    {
        $response = $this->get(route('antrian_poliklinik'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function token(): void
    {
        $response = $this->get(route('token'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function status_antrian(): void
    {
        $response = $this->post(route('status_antrian'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function ambil_antrian(): void
    {
        $response = $this->post(route('ambil_antrian'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function sisa_antrian(): void
    {
        $response = $this->post(route('sisa_antrian'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function batal_antrian(): void
    {
        $response = $this->post(route('batal_antrian'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function checkin_antrian(): void
    {
        $response = $this->post(route('checkin_antrian'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function info_pasien_baru(): void
    {
        $response = $this->post(route('info_pasien_baru'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function jadwal_operasi_rs(): void
    {
        $response = $this->post(route('jadwal_operasi_rs'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function jadwal_operasi_pasien(): void
    {
        $response = $this->post(route('jadwal_operasi_pasien'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function ambil_antrian_farmasi(): void
    {
        $response = $this->post(route('ambil_antrian_farmasi'));
        $response->assertStatus(200);
    }
    /**
     * @test
     */
    public function status_antrian_farmasi(): void
    {
        $response = $this->post(route('status_antrian_farmasi'));
        $response->assertStatus(200);
    }
}
