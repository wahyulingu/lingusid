<?php

namespace Database\Seeders;

use App\Actions\Group\EnsureSystemGroupExistsAction;
use App\Actions\Term\CreateTermAction;
use App\Enums\System\GroupEnum;
use App\Models\Term;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\progress;

class TermSeeder extends Seeder
{
    private array $termsData = [
        GroupEnum::RESIDENT_RELIGION->value => ['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'],
        GroupEnum::RESIDENT_MARITAL_STATUS->value => ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'],
        GroupEnum::RESIDENT_EDUCATION_LEVEL->value => ['Tidak/Belum Sekolah', 'Belum Tamat SD/Sederajat', 'Tamat SD/Sederajat', 'SLTP/Sederajat', 'SLTA/Sederajat', 'Diploma I/II', 'Akademi/Diploma III/S. Muda', 'Diploma IV/Strata I', 'Strata II', 'Strata III'],
        GroupEnum::RESIDENT_OCCUPATION->value => ['Petani', 'Nelayan', 'Pedagang', 'PNS', 'TNI', 'POLRI', 'Karyawan Swasta', 'Wiraswasta', 'Ibu Rumah Tangga', 'Pelajar/Mahasiswa', 'Pensiunan', 'Lainnya'],
        GroupEnum::RESIDENT_BLOOD_TYPE->value => ['A', 'B', 'AB', 'O', 'Tidak Tahu'],
        GroupEnum::FAMILY_RELATIONSHIP_STATUS->value => ['Kepala Keluarga', 'Istri', 'Anak', 'Menantu', 'Cucu', 'Orang Tua', 'Mertua', 'Famili Lain', 'Lainnya'],
        GroupEnum::GOVERNMENT_OFFICIAL_POSITION->value => ['Kepala Desa', 'Sekretaris Desa', 'Kepala Urusan Tata Usaha dan Umum', 'Kepala Urusan Keuangan', 'Kepala Urusan Perencanaan', 'Kepala Seksi Pemerintahan', 'Kepala Seksi Kesejahteraan', 'Kepala Seksi Pelayanan', 'Kepala Dusun'],
        GroupEnum::LEGAL_PRODUCT_CATEGORY->value => ['Peraturan Desa', 'Peraturan Kepala Desa', 'Keputusan Kepala Desa', 'Surat Edaran'],
        GroupEnum::DOCUMENT_LETTER_TYPE->value => ['Surat Keterangan Domisili', 'Surat Keterangan Usaha', 'Surat Keterangan Tidak Mampu', 'Surat Pengantar KTP', 'Surat Pengantar Nikah', 'Surat Keterangan Kematian'],
        GroupEnum::SOCIAL_ASSISTANCE_TYPE->value => ['Bantuan Langsung Tunai (BLT)', 'Program Keluarga Harapan (PKH)', 'Bantuan Pangan Non Tunai (BPNT)', 'Bantuan Sosial Tunai (BST)'],
        GroupEnum::VILLAGE_ASSET_TYPE->value => ['Tanah Kas Desa', 'Bangunan Kantor Desa', 'Kendaraan Dinas', 'Peralatan Kantor', 'Sarana Prasarana Umum'],
        GroupEnum::CONTENT_ARTICLE_CATEGORY->value => ['Berita Desa', 'Pengumuman', 'Potensi Desa', 'Produk Hukum', 'Kegiatan Desa'],
        GroupEnum::CONTENT_ARTICLE_TAG->value => ['Pembangunan', 'Sosial', 'Ekonomi', 'Pendidikan', 'Kesehatan', 'Lingkungan', 'Budaya', 'Pemerintahan'],
        GroupEnum::MEDIA_GALLERY_ALBUM->value => ['Dokumentasi Kegiatan', 'Foto Pembangunan', 'Video Profil Desa'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(EnsureSystemGroupExistsAction $ensureSystemGroupExists, CreateTermAction $createTerm): void
    {
        DB::transaction(function () use ($ensureSystemGroupExists, $createTerm) {

            $data = collect($this->termsData)
                ->map(
                    fn (array $value, string $key) => [
                        'groupKey' => $key,
                        'terms' => $value,
                    ]);

            $flatTerms = collect($data)->flatMap(function ($item) {
                return collect($item['terms'])->map(fn ($term) => [
                    'term' => $term,
                    'groupKey' => $item['groupKey'],
                    'groupLabel' => $item['groupLabel'] ?? ucfirst(str_replace('_', ' ', $item['groupKey'])),
                ]);
            })->values();

            $flatTerms = collect($data)->flatMap(function ($item) {
                return collect($item['terms'])->map(fn ($term) => [
                    'term' => $term,
                    'groupKey' => $item['groupKey'],
                    'groupLabel' => $item['groupLabel'] ?? ucfirst(str_replace('_', ' ', $item['groupKey'])),
                ]);
            })->values();

            $progress = progress(
                label: '🔄 Menanamkan frasa ke dalam sistem...',
                steps: $flatTerms->toArray(),
            );

            $flatTerms->each(function ($item) use ($ensureSystemGroupExists, $createTerm, $progress, $flatTerms) {
                $progress
                    ->label('📌 Memproses frasa: '.$item['groupKey'])
                    ->hint('Kategori: '.$item['groupLabel']);

                $ensureSystemGroupExists
                    ->execute($item['groupKey'], $item['groupLabel'])
                    ->morph(Term::class)
                    ->save($createTerm->execute($item['term']));

                if ($flatTerms->last() === $item) {
                    $progress
                        ->label('✅ Semua frasa telah berhasil ditanamkan ke dalam sistem.')
                        ->hint('Selesai 🎉');
                }

                $progress->advance();
            });

        });
    }
}
