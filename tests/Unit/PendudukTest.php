<?php

namespace Tests\Unit;

use App\Models\Penduduk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PendudukTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_can_create_penduduk()
    {
        $penduduk = Penduduk::create([
            'nik' => '1234567890123456',
            'nama_lengkap' => 'John Doe',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Contoh No. 1',
            'status_perkawinan' => 'Belum Kawin',
            'pekerjaan' => 'Karyawan Swasta',
        ]);

        $this->assertNotNull($penduduk);
        $this->assertEquals('1234567890123456', $penduduk->nik);
        $this->assertEquals('John Doe', $penduduk->nama_lengkap);
        $this->assertEquals('john-doe', $penduduk->slug); // Sluggable should convert to lowercase
    }

    #[Test]
    public function test_penduduk_fillable_attributes()
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

        $penduduk = Penduduk::create($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $penduduk->{$key});
        }
    }

    #[Test]
    public function test_penduduk_slug_generation()
    {
        $penduduk = Penduduk::create([
            'nik' => '1122334455667788',
            'nama_lengkap' => 'Nama Lengkap Dengan Spasi',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1985-11-20',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Contoh No. 3',
            'status_perkawinan' => 'Belum Kawin',
            'pekerjaan' => 'PNS',
        ]);

        $this->assertEquals('nama-lengkap-dengan-spasi', $penduduk->slug);
    }
}
