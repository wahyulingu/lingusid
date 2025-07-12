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
                'name' => 'Resident Management',
                'url' => '#',
                'icon' => 'users',
                'children' => [
                    ['name' => 'Resident Data', 'url' => '/dashboard/sid/resident'],
                    ['name' => 'Family', 'url' => '/dashboard/sid/keluarga'],
                    ['name' => 'Household', 'url' => '/dashboard/sid/rumah-tangga'],
                ],
            ],
            [
                'name' => 'Statistics',
                'url' => '#',
                'icon' => 'bar-chart-2',
                'children' => [
                    ['name' => 'Resident Statistics', 'url' => '/dashboard/statistik/resident'],
                    ['name' => 'Statistical Reports', 'url' => '/dashboard/statistik/laporan'],
                ],
            ],
            [
                'name' => 'Correspondence Services',
                'url' => '#',
                'icon' => 'mail',
                'children' => [
                    ['name' => 'Letter Submission', 'url' => '/dashboard/surat/pengajuan'],
                    ['name' => 'Letter Archive', 'url' => '/dashboard/surat/arsip'],
                ],
            ],
            [
                'name' => 'Finance',
                'url' => '#',
                'icon' => 'dollar-sign',
                'children' => [
                    ['name' => 'Revenue Budget', 'url' => '/dashboard/keuangan/pendapatan'],
                    ['name' => 'Expenditure Budget', 'url' => '/dashboard/keuangan/belanja'],
                ],
            ],
            [
                'name' => 'Development',
                'url' => '#',
                'icon' => 'briefcase',
                'children' => [
                    ['name' => 'Development Projects', 'url' => '/dashboard/pembangunan/proyek'],
                    ['name' => 'Development Reports', 'url' => '/dashboard/pembangunan/laporan'],
                ],
            ],
            [
                'name' => 'Village Assets',
                'url' => '#',
                'icon' => 'archive',
                'children' => [
                    ['name' => 'Asset Data', 'url' => '/dashboard/aset/data'],
                    ['name' => 'Asset Depreciation', 'url' => '/dashboard/aset/penyusutan'],
                ],
            ],
            [
                'name' => 'Social Assistance',
                'url' => '#',
                'icon' => 'heart',
                'children' => [
                    ['name' => 'Assistance Programs', 'url' => '/dashboard/bansos/program'],
                    ['name' => 'Assistance Recipients', 'url' => '/dashboard/bansos/penerima'],
                ],
            ],
            [
                'name' => 'Public Information',
                'url' => '#',
                'icon' => 'info',
                'children' => [
                    ['name' => 'Announcements', 'url' => '/dashboard/info/pengumuman'],
                    ['name' => 'Village News', 'url' => '/dashboard/info/berita'],
                ],
            ],
            [
                'name' => 'Village Institutions',
                'url' => '#',
                'icon' => 'shield',
                'children' => [
                    ['name' => 'Organizational Structure', 'url' => '/dashboard/lembaga/struktur'],
                    ['name' => 'Institution Members', 'url' => '/dashboard/lembaga/anggota'],
                ],
            ],
            [
                'name' => 'Settings',
                'url' => '#',
                'icon' => 'settings',
                'children' => [
                    ['name' => 'Users', 'url' => '/dashboard/pengaturan/pengguna'],
                    ['name' => 'Roles', 'url' => '/dashboard/pengaturan/peran'],
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
            ['name' => 'Home', 'url' => '/'],
            ['name' => 'Village Profile', 'url' => '/profil'],
            ['name' => 'News', 'url' => '/berita'],
            ['name' => 'Contact', 'url' => '/kontak'],
        ];

        foreach ($menus as $menuData) {
            $menu = Menu::create($menuData);
            $menu->groups()->attach($group);
        }
    }
}