<?php

namespace Tests\Unit;

use App\Models\Resident;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ResidentTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_can_create_resident()
    {
        $resident = Resident::create([
            'nik' => '1234567890123456',
            'nama_lengkap' => 'John Doe',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Contoh No. 1',
            'status_perkawinan' => 'Belum Kawin',
            'pekerjaan' => 'Karyawan Swasta',
        ]);

        $this->assertNotNull($resident);
        $this->assertEquals('1234567890123456', $resident->nik);
        $this->assertEquals('John Doe', $resident->nama_lengkap);
    }

    #[Test]
    public function test_resident_fillable_attributes()
    {
        $data = [
            'nik' => '6543210987654321',
            'nama_lengkap' => 'Jane Doe',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1992-05-10',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Contoh No. 2',
            'status_perkawinan' => 'Kawin',
            'pekerjaan' => 'Wiraswasta',
        ];

        $resident = Resident::create($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $resident->{$key});
        }
    }
}
