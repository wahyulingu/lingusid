# LinguSID

LinguSID adalah sebuah Sistem Informasi Desa (SID) berbasis web yang dirancang untuk membantu pemerintah desa dalam mengelola administrasi, meningkatkan kualitas pelayanan publik, dan mewujudkan transparansi informasi secara digital. Aplikasi ini dibangun dengan arsitektur modern untuk memastikan kemudahan penggunaan, keamanan data, dan skalabilitas di masa depan.

## Latar Belakang

Pemerintahan desa memiliki tanggung jawab besar dalam mengelola data residents, administrasi pertanahan, keuangan, serta menyelenggarakan pelayanan yang cepat dan akurat bagi warganya. Proses yang dilakukan secara manual seringkali memakan waktu, rentan terhadap kesalahan, dan menyulitkan pelacakan. LinguSID hadir sebagai solusi untuk mentransformasi proses-proses tersebut menjadi lebih efisien, terpusat, dan transparan.

## Fitur Utama

LinguSID dilengkapi dengan serangkaian fitur komprehensif yang mencakup berbagai aspek kebutuhan administrasi dan pelayanan desa:

#### 1. Resident Data Management
- **Resident & Family Data:** Detailed recording of resident data, including personal information, marital status, education, occupation, and family relationships.
- **Life Cycle:** Management of important events such as births, deaths, and population movements (arrivals and departures) recorded systematically.
- **Vulnerable Groups:** Feature to manage and monitor data of vulnerable or special needs groups in the village.

#### 2. Correspondence Administration
- **Automatic Letter Generator:** Ease of creating and printing various types of certificates (such as business certificates, domicile, incapacity, etc.) quickly with data integrated directly from the resident database.
- **Dynamic Templates:** Dozens of ready-to-use letter templates that can be adjusted to the format or regulations applicable in each region.
- **Digital Archive:** Every issued letter will be digitally archived, complete with letter number and issuance date for easy retrieval.

#### 3. Social Assistance Program Management
- **Prospective Recipient Data Collection:** Managing lists of prospective and actual recipients of social assistance programs from various sources (central government, regional, or village funds).
- **Eligibility Analysis:** The system can help analyze and rank prospective recipients based on established criteria to ensure assistance is well-targeted.
- **Reporting & Monitoring:** Monitoring and reporting the realization of aid distribution to citizens.

#### 4. Statistics and Demographics
- **Interactive Dashboard:** Presenting resident data in visual forms such as pie charts, bar graphs, and population pyramids.
- **Dynamic Reports:** Generating statistical reports based on various categories such as age range, gender, education level, religion, and occupation.
- **Trend Analysis:** Assisting village governments in understanding demographic trends to support better development planning.

#### 5. Informasi Publik & Transparansi Desa
- **Portal Berita Desa:** Fitur untuk mempublikasikan berita terkini, pengumuman resmi, dan agenda kegiatan desa melalui situs web yang dapat diakses oleh publik.
- **Transparansi Anggaran:** Menyediakan halaman khusus untuk menampilkan ringkasan Anggaran Pendapatan dan Belanja Desa (APBDes) serta laporan realisasinya.
- **Produk Hukum:** Publikasi peraturan desa, surat keputusan kepala desa, dan produk hukum lainnya.

#### 6. Layanan Mandiri Warga
- **Permohonan Surat Online:** Warga dapat mengajukan permohonan pembuatan surat secara online melalui portal, mengurangi kebutuhan untuk datang langsung ke kantor desa.
- **Pembaruan Data:** Memungkinkan warga untuk memeriksa dan mengajukan usulan pembaruan data pribadi mereka (memerlukan verifikasi oleh operator).

## Teknologi

LinguSID dibangun menggunakan tumpukan teknologi yang handal dan modern:
- **Backend:** PHP & Laravel Framework
- **Frontend:** TypeScript, Vue.js, Inertia.js
- **Database:** MySQL / PostgreSQL / SQLite
- **Styling:** Tailwind CSS

---

Dengan fitur-fitur ini, LinguSID bertujuan untuk menjadi platform digital terpadu yang memberdayakan pemerintah desa dan melayani masyarakat dengan lebih baik.

## Pengembangan

Untuk menyiapkan lingkungan pengembangan, ikuti langkah-langkah berikut:

1.  **Kloning repositori:**
    ```bash
    git clone [repository_url]
    cd LinguSID
    ```
2.  **Instal dependensi PHP:**
    ```bash
    composer install
    ```
3.  **Instal dependensi JavaScript:**
    ```bash
    bun install
    ```
4.  **Salin file lingkungan dan buat kunci aplikasi:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
5.  **Konfigurasi basis data Anda di `.env` dan jalankan migrasi:**
    ```bash
    php artisan migrate
    ```
6.  **Jalankan server pengembangan:**
    ```bash
    php artisan serve
    bun run dev
    ```

### Menjalankan Tes

Untuk menjalankan tes, gunakan perintah berikut:
```bash
php artisan test
```

### Berkontribusi

Kami menyambut kontribusi! Silakan baca `CONTRIBUTING.md` kami (jika tersedia) untuk panduan tentang cara berkontribusi.