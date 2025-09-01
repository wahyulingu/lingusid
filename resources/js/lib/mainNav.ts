import { Nav } from '@/types';
import Lucide from 'lucide-vue-next';

export const mainNav: Nav[] = [
    {
        title: 'Utama',
        items: [
            {
                title: 'Dashboard',
                href: '/dashboard',
                icon: Lucide.LayoutGrid,
            },
        ],
    },
    {
        title: 'Info Desa',
        items: [
            {
                title: 'Identitas Desa',
                href: '/dashboard/sid/village/identity',
                icon: Lucide.Info,
            },
            {
                title: 'Pemerintahan Desa',
                href: '/dashboard/sid/village/government',
                icon: Lucide.Landmark,
            },
            {
                title: 'Wilayah Administratif',
                href: '/dashboard/sid/village/areas',
                icon: Lucide.Map,
            },
            {
                title: 'Lembaga Desa',
                href: '/dashboard/sid/village/institutions',
                icon: Lucide.Library,
            },
        ],
    },
    {
        title: 'Kependudukan',
        items: [
            {
                title: 'Penduduk',
                href: '/dashboard/sid/population/residents',
                icon: Lucide.UsersRound,
            },
            {
                title: 'Keluarga',
                href: '/dashboard/sid/population/families',
                icon: Lucide.Home,
            },
            {
                title: 'Rumah Tangga',
                href: '/dashboard/sid/population/households',
                icon: Lucide.Building,
            },
            {
                title: 'Kelompok',
                href: '/dashboard/sid/population/groups',
                icon: Lucide.Users,
            },
        ],
    },
    {
        title: 'Layanan Surat',
        items: [
            {
                title: 'Arsip Surat',
                href: '/dashboard/sid/letters/archives',
                icon: Lucide.Archive,
            },
            {
                title: 'Cetak Surat',
                href: '/dashboard/sid/letters/print',
                icon: Lucide.Printer,
            },
            {
                title: 'Pengaturan Surat',
                href: '/dashboard/sid/letters/settings',
                icon: Lucide.FileCog,
            },
        ],
    },
    {
        title: 'Sekretariat',
        items: [
            {
                title: 'Agenda',
                href: '/dashboard/sid/secretariat/agendas',
                icon: Lucide.CalendarCheck,
            },
            {
                title: 'Buku Administrasi',
                href: '/dashboard/sid/secretariat/books',
                icon: Lucide.BookCopy,
            },
        ],
    },
    {
        title: 'Keuangan',
        items: [
            {
                title: 'APBD Desa',
                href: '/dashboard/sid/finance',
                icon: Lucide.Wallet,
            },
        ],
    },
    {
        title: 'Pembangunan',
        items: [
            {
                title: 'Data Pembangunan',
                href: '/dashboard/sid/development',
                icon: Lucide.Construction,
            },
        ],
    },
    {
        title: 'Pertanahan',
        items: [
            {
                title: 'Data Pertanahan',
                href: '/dashboard/sid/lands',
                icon: Lucide.Tractor,
            },
        ],
    },
    {
        title: 'Analisis',
        items: [
            {
                title: 'Master Analisis',
                href: '/dashboard/sid/analysis/master',
                icon: Lucide.Database,
            },
            {
                title: 'Input Data',
                href: '/dashboard/sid/analysis/input',
                icon: Lucide.FilePlus,
            },
            {
                title: 'Laporan',
                href: '/dashboard/sid/analysis/reports',
                icon: Lucide.FileText,
            },
        ],
    },
    {
        title: 'Bantuan',
        items: [
            {
                title: 'Program Bantuan',
                href: '/dashboard/sid/assistances',
                icon: Lucide.HeartHandshake,
            },
        ],
    },
    {
        title: 'Website',
        items: [
            {
                title: 'Artikel',
                href: '/dashboard/web/articles',
                icon: Lucide.Newspaper,
            },
            {
                title: 'Halaman',
                href: '/dashboard/web/pages',
                icon: Lucide.LayoutTemplate,
            },
            {
                title: 'Galeri',
                href: '/dashboard/web/galleries',
                icon: Lucide.GalleryVertical,
            },
            {
                title: 'Menu',
                href: '/dashboard/web/menus',
                icon: Lucide.Menu,
            },
        ],
    },
    {
        title: 'Statistik',
        items: [
            {
                title: 'Kependudukan',
                href: '/dashboard/sid/statistics/population',
                icon: Lucide.AreaChart,
            },
            {
                title: 'Laporan Statistik',
                href: '/dashboard/sid/statistics/reports',
                icon: Lucide.PieChart,
            },
        ],
    },
    {
        title: 'Lainnya',
        items: [
            {
                title: 'Perpustakaan',
                href: '/dashboard/sid/library',
                icon: Lucide.Library,
            },
            {
                title: 'Pengaduan',
                href: '/dashboard/sid/complaints',
                icon: Lucide.MessageSquareText,
            },
        ],
    },
    {
        title: 'Pengaturan',
        items: [
            {
                title: 'Pengguna',
                href: '/dashboard/settings/users',
                icon: Lucide.BookUser,
            },
            {
                title: 'Aplikasi',
                href: '/dashboard/settings/application',
                icon: Lucide.Settings,
            },
            {
                title: 'Database',
                href: '/dashboard/settings/database',
                icon: Lucide.Database,
            },
            {
                title: 'Info Sistem',
                href: '/dashboard/settings/system-info',
                icon: Lucide.MonitorPlay,
            },
            {
                title: 'Log',
                href: '/dashboard/settings/logs',
                icon: Lucide.ScrollText,
            },
            {
                title: 'Bantuan',
                href: '/dashboard/settings/help',
                icon: Lucide.CircleHelp,
            },
        ],
    },
];
