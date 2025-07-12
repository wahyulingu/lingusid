# Panduan Kontribusi

Kami sangat menghargai kontribusi Anda untuk proyek LinguSID! Dengan mengikuti panduan ini, Anda dapat membantu kami menjaga kualitas kode, konsistensi, dan memastikan pengalaman kolaborasi yang lancar bagi semua.

## Kode Etik

Proyek ini dan semua pesertanya diatur oleh [Kode Etik](CODE_OF_CONDUCT.md) kami. Dengan berpartisipasi, Anda diharapkan untuk menjunjung tinggi kode ini.

## Bagaimana Cara Berkontribusi?

Ada banyak cara untuk berkontribusi pada proyek LinguSID:

### Melaporkan Bug

Jika Anda menemukan bug, silakan laporkan dengan mengikuti langkah-langkah berikut:

1.  Periksa [Issues](https://github.com/your-username/LinguSID/issues) yang sudah ada untuk melihat apakah bug tersebut sudah dilaporkan.
2.  Jika belum, buka Issue baru dan berikan informasi berikut:
    *   **Judul Deskriptif:** Singkat dan jelas.
    *   **Langkah-langkah Reproduksi:** Jelaskan langkah-langkah yang tepat untuk mereproduksi bug.
    *   **Perilaku yang Diharapkan:** Apa yang seharusnya terjadi.
    *   **Perilaku Aktual:** Apa yang sebenarnya terjadi.
    *   **Versi LinguSID:** Versi proyek yang Anda gunakan.
    *   **Lingkungan:** Sistem operasi, versi PHP, versi Node.js, dll.
    *   **Tangkapan Layar/Video (Opsional):** Jika relevan, sertakan tangkapan layar atau video.

### Mengusulkan Peningkatan

Jika Anda memiliki ide untuk fitur baru atau peningkatan pada fitur yang sudah ada, silakan buka Issue baru dengan informasi berikut:

1.  **Judul Deskriptif:** Singkat dan jelas.
2.  **Deskripsi Fitur:** Jelaskan secara rinci fitur atau peningkatan yang Anda usulkan.
3.  **Kasus Penggunaan:** Bagaimana fitur ini akan digunakan dan siapa yang akan diuntungkan.
4.  **Alternatif (Opsional):** Jika ada, jelaskan solusi atau pendekatan alternatif yang telah Anda pertimbangkan.

### Kontribusi Kode

Kami menyambut kontribusi kode! Ikuti panduan di bawah ini untuk memastikan Pull Request (PR) Anda dapat ditinjau dan digabungkan dengan cepat.

#### Persiapan Lingkungan Pengembangan

Pastikan Anda telah mengikuti instruksi penyiapan lingkungan pengembangan di `README.md`.

#### Alur Kerja Pull Request

1.  **Fork** repositori dan **kloning** fork Anda secara lokal.
2.  Buat **cabang baru** dari cabang `develop` untuk fitur atau perbaikan bug Anda:
    ```bash
    git checkout develop
    git pull origin develop
    git checkout -b feature/nama-fitur-anda
    # atau
    git checkout -b bugfix/nama-perbaikan-bug-anda
    ```
3.  Lakukan perubahan Anda. Pastikan untuk mengikuti [Panduan Gaya Kode](#panduan-gaya-kode) dan [Panduan Pesan Komit](#panduan-pesan-komit).
4.  **Uji** perubahan Anda secara menyeluruh. Pastikan semua tes yang ada lulus dan tambahkan tes baru jika diperlukan untuk perubahan Anda.
    ```bash
    php artisan test
    ```
5.  **Linting dan Pemformatan:** Pastikan kode Anda sesuai dengan standar proyek.
    ```bash
    # Contoh untuk PHP
    ./vendor/bin/phpcs --standard=PSR12 app/
    # Contoh untuk JavaScript/TypeScript
    bun run lint
    bun run format
    ```
6.  **Komit** perubahan Anda dengan pesan komit yang jelas dan deskriptif.
7.  **Dorong** cabang Anda ke fork Anda:
    ```bash
    git push origin feature/nama-fitur-anda
    ```
8.  Buka **Pull Request** ke cabang `develop` di repositori utama.

#### Panduan Gaya Kode

*   **PHP:** Ikuti standar [PSR-12](https://www.php-fig.org/psr/psr-12/). Gunakan PHP-CS-Fixer atau PHP_CodeSniffer untuk memformat kode Anda.
*   **JavaScript/TypeScript:** Ikuti konfigurasi Prettier dan ESLint yang ada di proyek.

#### Panduan Pesan Komit

Pesan komit harus jelas, ringkas, dan deskriptif. Kami merekomendasikan untuk mengikuti konvensi [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/).

Contoh:
```
feat: tambahkan fitur manajemen pengguna

Ini adalah deskripsi yang lebih rinci tentang fitur manajemen pengguna.
- Tambahkan model User
- Tambahkan migrasi database
- Tambahkan aksi CreateUserAction
```

#### Menjalankan Tes

Sebelum mengirimkan Pull Request, pastikan Anda telah menjalankan tes dan semuanya lulus.
```bash
php artisan test
```
Jika Anda menambahkan fungsionalitas baru, pastikan untuk menulis tes unit dan/atau fitur yang sesuai.

## Pertanyaan?

Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk membuka Issue atau menghubungi kami.

Terima kasih atas kontribusi Anda!
