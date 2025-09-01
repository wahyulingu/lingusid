import { Nav } from '@/types';
import {
    Archive,
    AreaChart,
    BookCopy,
    BookUser,
    Building,
    CalendarCheck,
    CircleHelp,
    Construction,
    Database,
    FileCog,
    FilePlus,
    FileText,
    GalleryVertical,
    HeartHandshake,
    Home,
    Info,
    Landmark,
    LayoutGrid,
    LayoutTemplate,
    Library,
    Map,
    Menu,
    MessageSquareText,
    MonitorPlay,
    Newspaper,
    PieChart,
    Printer,
    ScrollText,
    Settings,
    Tractor,
    Users,
    UsersRound,
    Wallet,
} from 'lucide-vue-next';

export const mainNav: Nav[] = [
    {
        title: 'Utama',
        items: [
            {
                title: 'Dashboard',
                href: '/dashboard',
                icon: LayoutGrid,
            },
        ],
    },
    {
        title: 'Info Desa',
        items: [
            {
                title: 'Identitas Desa',
                href: '/dashboard/sid/village/identity',
                icon: Info,
            },
            {
                title: 'Pemerintahan Desa',
                href: '/dashboard/sid/village/government',
                icon: Landmark,
            },
            {
                title: 'Wilayah Administratif',
                href: '/dashboard/sid/village/areas',
                icon: Map,
            },
            {
                title: 'Lembaga Desa',
                href: '/dashboard/sid/village/institutions',
                icon: Library,
            },
        ],
    },
    {
        title: 'Kependudukan',
        items: [
            {
                title: 'Penduduk',
                href: '/dashboard/sid/population/residents',
                icon: UsersRound,
            },
            {
                title: 'Keluarga',
                href: '/dashboard/sid/population/families',
                icon: Home,
            },
            {
                title: 'Rumah Tangga',
                href: '/dashboard/sid/population/households',
                icon: Building,
            },
            {
                title: 'Kelompok',
                href: '/dashboard/sid/population/groups',
                icon: Users,
            },
        ],
    },
    {
        title: 'Layanan Surat',
        items: [
            {
                title: 'Arsip Surat',
                href: '/dashboard/sid/letters/archives',
                icon: Archive,
            },
            {
                title: 'Cetak Surat',
                href: '/dashboard/sid/letters/print',
                icon: Printer,
            },
            {
                title: 'Pengaturan Surat',
                href: '/dashboard/sid/letters/settings',
                icon: FileCog,
            },
        ],
    },
    {
        title: 'Sekretariat',
        items: [
            {
                title: 'Agenda',
                href: '/dashboard/sid/secretariat/agendas',
                icon: CalendarCheck,
            },
            {
                title: 'Buku Administrasi',
                href: '/dashboard/sid/secretariat/books',
                icon: BookCopy,
            },
        ],
    },
    {
        title: 'Keuangan',
        items: [
            {
                title: 'APBD Desa',
                href: '/dashboard/sid/finance',
                icon: Wallet,
            },
        ],
    },
    {
        title: 'Pembangunan',
        items: [
            {
                title: 'Data Pembangunan',
                href: '/dashboard/sid/development',
                icon: Construction,
            },
        ],
    },
    {
        title: 'Pertanahan',
        items: [
            {
                title: 'Data Pertanahan',
                href: '/dashboard/sid/lands',
                icon: Tractor,
            },
        ],
    },
    {
        title: 'Analisis',
        items: [
            {
                title: 'Master Analisis',
                href: '/dashboard/sid/analysis/master',
                icon: Database,
            },
            {
                title: 'Input Data',
                href: '/dashboard/sid/analysis/input',
                icon: FilePlus,
            },
            {
                title: 'Laporan',
                href: '/dashboard/sid/analysis/reports',
                icon: FileText,
            },
        ],
    },
    {
        title: 'Bantuan',
        items: [
            {
                title: 'Program Bantuan',
                href: '/dashboard/sid/assistances',
                icon: HeartHandshake,
            },
        ],
    },
    {
        title: 'Website',
        items: [
            {
                title: 'Artikel',
                href: '/dashboard/web/articles',
                icon: Newspaper,
            },
            {
                title: 'Halaman',
                href: '/dashboard/web/pages',
                icon: LayoutTemplate,
            },
            {
                title: 'Galeri',
                href: '/dashboard/web/galleries',
                icon: GalleryVertical,
            },
            {
                title: 'Menu',
                href: '/dashboard/web/menus',
                icon: Menu,
            },
        ],
    },
    {
        title: 'Statistik',
        items: [
            {
                title: 'Kependudukan',
                href: '/dashboard/sid/statistics/population',
                icon: AreaChart,
            },
            {
                title: 'Laporan Statistik',
                href: '/dashboard/sid/statistics/reports',
                icon: PieChart,
            },
        ],
    },
    {
        title: 'Lainnya',
        items: [
            {
                title: 'Perpustakaan',
                href: '/dashboard/sid/library',
                icon: Library,
            },
            {
                title: 'Pengaduan',
                href: '/dashboard/sid/complaints',
                icon: MessageSquareText,
            },
        ],
    },
    {
        title: 'Pengaturan',
        items: [
            {
                title: 'Pengguna',
                href: '/dashboard/settings/users',
                icon: BookUser,
            },
            {
                title: 'Aplikasi',
                href: '/dashboard/settings/application',
                icon: Settings,
            },
            {
                title: 'Database',
                href: '/dashboard/settings/database',
                icon: Database,
            },
            {
                title: 'Info Sistem',
                href: '/dashboard/settings/system-info',
                icon: MonitorPlay,
            },
            {
                title: 'Log',
                href: '/dashboard/settings/logs',
                icon: ScrollText,
            },
            {
                title: 'Bantuan',
                href: '/dashboard/settings/help',
                icon: CircleHelp,
            },
        ],
    },
];
