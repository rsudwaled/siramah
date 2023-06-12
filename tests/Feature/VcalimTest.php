<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VcalimTest extends TestCase
{
    /**
     * @test
     */
    public function monitoring_data_kunjungan(): void
    {
        $response = $this->get(route('monitoring_data_kunjungan', [
            'tanggal' => '2023-06-12',
            'jenispelayanan' => '2',
        ]));
        $response->assertStatus($response->getData()->metadata->code);
    }
    /**
     * @test
     */
    public function monitoring_data_klaim(): void
    {
        $response = $this->get(route('monitoring_data_klaim', [
            'tanggalPulang' => '2023-01-12',
            'jenisPelayanan' => '2',
            'statusKlaim' => '3',
        ]));
        $response->assertStatus($response->getData()->metadata->code);
    }
    /**
     * @test
     */
    public function monitoring_pelayanan_peserta(): void
    {
        $response = $this->get(route('monitoring_pelayanan_peserta', [
            'tanggalPulang' => '2023-01-12',
            'jenisPelayanan' => '2',
            'statusKlaim' => '3',
        ]));
        $response->assertStatus($response->getData()->metadata->code);
    }
    /**
     * @test
     */
    public function monitoring_klaim_jasaraharja(): void
    {
        $response = $this->get(route('monitoring_klaim_jasaraharja', [
            'tanggalPulang' => '2023-01-12',
            'jenisPelayanan' => '2',
            'statusKlaim' => '3',
        ]));
        $response->assertStatus($response->getData()->metadata->code);
    }
    /**
     * @test
     */
    public function peserta_nomorkartu(): void
    {
        $response = $this->get(route('peserta_nomorkartu', [
            'tanggalPulang' => '2023-01-12',
            'jenisPelayanan' => '2',
            'statusKlaim' => '3',
        ]));
        $response->assertStatus($response->getData()->metadata->code);
    }
    /**
     * @test
     */
    public function peserta_nik(): void
    {
        $response = $this->get(route('peserta_nik', [
            'tanggalPulang' => '2023-01-12',
            'jenisPelayanan' => '2',
            'statusKlaim' => '3',
        ]));
        $response->assertStatus($response->getData()->metadata->code);
    }
}
