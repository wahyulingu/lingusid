<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dashboardGroup = Group::create([
            'name' => 'Menu Dashboard',
            'slug' => 'menu-dashboard',
            'type' => 'menu',
        ]);

        $webUmumGroup = Group::create([
            'name' => 'Menu Web Umum',
            'slug' => 'menu-web-umum',
            'type' => 'menu',
        ]);

        // Menu Dashboard
        $this->createDashboardMenus($dashboardGroup);

        // Menu Web Umum
        $this->createWebUmumMenus($webUmumGroup);
    }

    private function createDashboardMenus(Group $group): void
    {
        $menus = [
            [
                'name' => 'Kependudukan',
                'url' => '#',
                'icon' => 'users',
                'children' => [
                    ['name' => 'Data Penduduk', 'url' => '/dashboard/sid/penduduk'],
                    ['name' => 'Keluarga', 'url' => '/dashboard/sid/keluarga'],
                    ['name' => 'Rumah Tangga', 'url' => '/dashboard/sid/rumah-tangga'],
                ],
            ],
            [
                'name' => 'Statistik',
                'url' => '#',
                'icon' => 'bar-chart-2',
                'children' => [
                    ['name' => 'Statistik Kependudukan', 'url' => '/dashboard/statistik/kependudukan'],
                    ['name' => 'Laporan Statistik', 'url' => '/dashboard/statistik/laporan'],
                ],
            ],
            [
                'name' => 'Layanan Surat',
                'url' => '#',
                'icon' => 'mail',
                'children' => [
                    ['name' => 'Pengajuan Surat', 'url' => '/dashboard/surat/pengajuan'],
                    ['name' => 'Arsip Surat', 'url' => '/dashboard/surat/arsip'],
                ],
            ],
            [
                'name' => 'Keuangan',
                'url' => '#',
                'icon' => 'dollar-sign',
                'children' => [
                    ['name' => 'Anggaran Pendapatan', 'url' => '/dashboard/keuangan/pendapatan'],
                    ['name' => 'Anggaran Belanja', 'url' => '/dashboard/keuangan/belanja'],
                ],
            ],
            [
                'name' => 'Pembangunan',
                'url' => '#',
                'icon' => 'briefcase',
                'children' => [
                    ['name' => 'Proyek Pembangunan', 'url' => '/dashboard/pembangunan/proyek'],
                    ['name' => 'Laporan Pembangunan', 'url' => '/dashboard/pembangunan/laporan'],
                ],
            ],
            [
                'name' => 'Aset Desa',
                'url' => '#',
                'icon' => 'archive',
                'children' => [
                    ['name' => 'Data Aset', 'url' => '/dashboard/aset/data'],
                    ['name' => 'Penyusutan Aset', 'url' => '/dashboard/aset/penyusutan'],
                ],
            ],
            [
                'name' => 'Bantuan Sosial',
                'url' => '#',
                'icon' => 'heart',
                'children' => [
                    ['name' => 'Program Bantuan', 'url' => '/dashboard/bansos/program'],
                    ['name' => 'Penerima Bantuan', 'url' => '/dashboard/bansos/penerima'],
                ],
            ],
            [
                'name' => 'Informasi Publik',
                'url' => '#',
                'icon' => 'info',
                'children' => [
                    ['name' => 'Pengumuman', 'url' => '/dashboard/info/pengumuman'],
                    ['name' => 'Berita Desa', 'url' => '/dashboard/info/berita'],
                ],
            ],
            [
                'name' => 'Lembaga Desa',
                'url' => '#',
                'icon' => 'shield',
                'children' => [
                    ['name' => 'Struktur Organisasi', 'url' => '/dashboard/lembaga/struktur'],
                    ['name' => 'Anggota Lembaga', 'url' => '/dashboard/lembaga/anggota'],
                ],
            ],
            [
                'name' => 'Pengaturan',
                'url' => '#',
                'icon' => 'settings',
                'children' => [
                    ['name' => 'Pengguna', 'url' => '/dashboard/pengaturan/pengguna'],
                    ['name' => 'Peran', 'url' => '/dashboard/pengaturan/peran'],
                ],
            ],
        ];

        foreach ($menus as $menuData) {
            $parent = Menu::create([
                'name' => $menuData['name'],
                'url' => $menuData['url'],
                'icon' => $menuData['icon'],
            ]);
            $parent->groups()->attach($group);

            foreach ($menuData['children'] as $childData) {
                $child = Menu::create([
                    'name' => $childData['name'],
                    'url' => $childData['url'],
                    'parent_id' => $parent->id,
                ]);
                $child->groups()->attach($group);
            }
        }
    }

    private function createWebUmumMenus(Group $group): void
    {
        $menus = [
            ['name' => 'Beranda', 'url' => '/'],
            ['name' => 'Profil Desa', 'url' => '/profil'],
            ['name' => 'Berita', 'url' => '/berita'],
            ['name' => 'Kontak', 'url' => '/kontak'],
        ];

        foreach ($menus as $menuData) {
            $menu = Menu::create($menuData);
            $menu->groups()->attach($group);
        }
    }
}