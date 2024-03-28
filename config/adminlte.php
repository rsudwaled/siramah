<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Sistem RSUD Waled',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => 'RSUD Waled',
    'logo_img' => 'vendor/adminlte/dist/img/rswaledico.png',
    'logo_img_class' => 'brand-image',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'SIRAMAH-RS Waled',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/rswaledico.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 'auto',
            'height' => 'auto',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => 'text-xs',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => true,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => false,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => 'profile',

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => true,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        ['header' => 'MENU UTAMA'],
        [
            'text'        => 'Landing Page',
            'url'         => '',
            'icon'        => 'fas fa-globe',
        ],
        [
            'text'        => 'Dashboard',
            'url'         => 'home',
            'icon'        => 'fas fa-home',
        ],
        // PELAYANAN
        [
            'text'    => 'Aplikasi Pelayanan',
            'icon'    => 'fas fa-clinic-medical',
            'submenu' => [
                [
                    'text' => 'Aplikasi Mesin Antrian',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'antrianConsole',
                    'shift'   => 'ml-2',
                    'can' => ['pendaftaran', 'rekam-medis'],
                ],
                [
                    'text' => 'Aplikasi Checkin Antrian',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'checkinAntrian',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran', 'rekam-medis'],
                ],
                [
                    'text' => 'Antrian Pendaftaran',
                    'icon'    => 'fas fa-user-plus',
                    'url'  => 'antrianPendaftaran',
                    'shift'   => 'ml-2',
                    'can' => ['pendaftaran', 'rekam-medis'],
                ],
                [
                    'text' => 'Antrian Pembayaran',
                    'icon'    => 'fas fa-hand-holding-usd',
                    'url'  => 'antrian/pembayaran',
                    'shift'   => 'ml-2',
                    'can' => 'kasir',
                ],
                [
                    'text' => 'Kunjungan Poliklinik',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'kunjungan_rajal',
                    'shift'   => 'ml-2',
                    'can' => 'poliklinik',
                ],
                [
                    'text' => 'Antrian Poliklinik',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'antrianPoliklinik',
                    'shift'   => 'ml-2',
                    'can' => 'poliklinik',
                ],
                [
                    'text' => 'Surat Kontrol Poliklinik',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'kunjunganPoliklinik',
                    'shift'   => 'ml-2',
                    'can' => 'poliklinik',
                ],
                [
                    'text' => 'Antrian Farmasi',
                    'icon'    => 'fas fa-pills',
                    'url'  => 'antrianFarmasi',
                    'shift'   => 'ml-2',
                    'can' => 'farmasi',
                ],
                [
                    'text' => 'Order Farmasi',
                    'icon'    => 'fas fa-pills',
                    'url'  => 'orderFarmasi',
                    'shift'   => 'ml-2',
                    'can' => 'farmasi',
                ],
                [
                    'text' => 'Tracer Order Farmasi',
                    'icon'    => 'fas fa-pills',
                    'url'  => 'tracerOrderObat',
                    'shift'   => 'ml-2',
                    'can' => 'farmasi',
                ],
                [
                    'text' => 'Pasien Ranap Aktif',
                    'icon'    => 'fas fa-procedures',
                    'url'  => 'kunjunganranap',
                    'active' => ['kunjunganranap', 'pasienranapprofile'],
                    'shift'   => 'ml-2',
                    'can' => ['ranap','rekam-medis'],
                ],
                // [
                //     'text' => 'Pasien Ranap Aktif',
                //     'icon'    => 'fas fa-user-injured',
                //     'url'  => 'pasienRanapAktif',
                //     'shift'   => 'ml-2',
                //     'can' => 'ranap',
                // ],
                // [
                //     'text' => 'Pasien Ranap',
                //     'icon'    => 'fas fa-user-injured',
                //     'url'  => 'pasienRanap',
                //     'shift'   => 'ml-2',
                //     'active' => ['pasienRanapPasien', 'pasienRanap'],
                //     'can' => 'ranap',
                // ],

            ],
        ],
        // IGD VERSI 1
        [
            'text'    => 'Aplikasi IGD v1',
            'icon'    => 'fas fa-hospital-alt',
            'can' => 'pendaftaran-igd',
            'submenu' => [
                [
                    'text' => 'Daftar Pasien',
                    'icon'    => 'fas fa-chalkboard-teacher',
                    'url'  => 'daftar/pasien-igd',
                    'shift'   => 'ml-2',
                    'can' => 'pendaftaran-igd',
                ],
                [
                    'text' => 'Daftar Pasien Bayi',
                    'icon'    => 'fas fa-baby',
                    'url'  => 'tambah/pasien-bayi',
                    'shift'   => 'ml-2',
                    'can' => 'pendaftaran-igd',
                ],
                [
                    'text' => 'Kunjungan Pasien',
                    'icon'    => 'fas fa-address-book',
                    'url'  => 'daftar-kunjungan',
                    'shift'   => 'ml-2',
                    'can' => 'pendaftaran-igd',
                ],
                [
                    'text' => 'Pasien BPJS PROSES',
                    'icon'    => 'fas fa-thumbtack',
                    'url'  => 'pasien-bpjsproses/list-pasien',
                    'shift'   => 'ml-2',
                    'can' => 'pendaftaran-igd',
                ],

                [
                    'text' => 'Pasien Ranap',
                    'icon'    => 'fas fa-procedures',
                    'url'  => 'pasien-rawat-inap',
                    'shift'   => 'ml-2',
                    'can' => 'pendaftaran-igd',
                ],
                [
                    'text' => 'Pasien Kecelakaan',
                    'icon'    => 'fas fa-ambulance',
                    'url'  => 'list/pasien-kecelakaan',
                    'shift'   => 'ml-2',
                    'can' => 'pendaftaran-igd',
                ],
                [
                    'text' => 'Riwayat Pendaftaran byUser',
                    'icon'    => 'fas fa-user-plus',
                    'url'  => 'get-kunjungan/by-user',
                    'shift'   => 'ml-2',
                    'can' => 'pendaftaran-igd',
                ],

            ],
        ],
        // IGD VERSI 1.1
        // [
        //     'text'    => 'Aplikasi IGD',
        //     'icon'    => 'fas fa-hospital-alt',
        //     'can' => 'pendaftaran-igd',
        //     'submenu' => [
        //         // [
        //         //     'text' => 'Dashboard IGD',
        //         //     'icon'    => 'fas fa-columns',
        //         //     'url'  => 'dashboard-igd',
        //         //     'shift'   => 'ml-2',
        //         //     'can' => 'pendaftaran-igd',
        //         // ],
        //         [
        //             'text' => 'Daftar Antrian',
        //             'icon'    => 'fas fa-chalkboard-teacher',
        //             'url'  => 'list-antrian',
        //             'shift'   => 'ml-2',
        //             'can' => 'pendaftaran-igd',
        //         ],
        //         [
        //             'text' => 'Update Diagnosa',
        //             'icon'    => 'fas fa-stethoscope',
        //             'url'  => 'daftar-diagnosa/synch-diagnosa-assesment',
        //             'shift'   => 'ml-2',
        //             'can' => 'pendaftaran-igd',
        //         ],
        //         [
        //             'text' => 'Assesment Ranap',
        //             'icon'    => 'fas fa-notes-medical',
        //             'url'  => 'list-pasien/assesment-ranap',
        //             'shift'   => 'ml-2',
        //             'can' => 'pendaftaran-igd',
        //         ],
        //         [
        //             'text' => 'Pasien Ranap',
        //             'icon'    => 'fas fa-procedures',
        //             'url'  => 'pasien-rawat-inap',
        //             'shift'   => 'ml-2',
        //             'can' => 'pendaftaran-igd',
        //         ],
        //         [
        //             'text' => 'Pasien Kecelakaan',
        //             'icon'    => 'fas fa-ambulance',
        //             'url'  => 'list/pasien-kecelakaan',
        //             'shift'   => 'ml-2',
        //             'can' => 'pendaftaran-igd',
        //         ],
        //         [
        //             'text' => 'Pasien BPJS PROSES',
        //             'icon'    => 'fas fa-thumbtack',
        //             'url'  => 'pasien-bpjsproses/list-pasien',
        //             'shift'   => 'ml-2',
        //             'can' => 'pendaftaran-igd',
        //         ],
        //         [
        //             'text' => 'Kunjungan Pasien',
        //             'icon'    => 'fas fa-address-book',
        //             'url'  => 'daftar-kunjungan',
        //             'shift'   => 'ml-2',
        //             'can' => 'pendaftaran-igd',
        //         ],
        //         [
        //             'text' => 'Riwayat Pendaftaran byUser',
        //             'icon'    => 'fas fa-user-plus',
        //             'url'  => 'daftar-kunjungan-byuser',
        //             'shift'   => 'ml-2',
        //             'can' => 'pendaftaran-igd',
        //         ],

        //     ],
        // ],
        // PENGELOLAAN
        [
            'text'    => 'Pengelolaan',
            'icon'    => 'fas fa-hospital',
            'submenu' => [
                [
                    'text' => 'Pasien',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'pasien',
                    'shift'   => 'ml-2',
                    'active'  => ['pasien', 'pasien/create', 'regex:@^pasien(\/[0-9]+)?+$@', 'regex:@^pasien(\/[0-9]+)?\/edit+$@',],
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'Dokter',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'dokter',
                    'shift'   => 'ml-2',
                    'can' => 'pelayanan-medis',
                ],
                [
                    'text' => 'Paramedis',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'paramedis',
                    'shift'   => 'ml-2',
                    'can' => 'pelayanan-medis',
                ],
                [
                    'text' => 'Poliklinik',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'poliklinik',
                    'shift'   => 'ml-2',
                    'can' => 'pelayanan-medis',
                ],
                [
                    'text' => 'Unit',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'unit',
                    'shift'   => 'ml-2',
                    'can' => 'pelayanan-medis',
                ],
                [
                    'text' => 'Jadwal Dokter',
                    'icon'    => 'fas fa-calendar-alt',
                    'shift'   => 'ml-2',
                    'url'  => 'jadwaldokter',
                    'can' =>  ['pelayanan-medis', 'pendaftaran'],
                ],
                [
                    'text' => 'Jadwal Dokter Poliklinik',
                    'icon'    => 'fas fa-calendar-alt',
                    'shift'   => 'ml-2',
                    'url'  => 'jadwalDokterPoliklinik',
                    'can' =>  ['pelayanan-medis', 'poliklinik'],
                ],
                [
                    'text' => 'Kunjungan',
                    'icon'    => 'fas fa-hospital-user',
                    'url'  => 'kunjungan',
                    'shift'   => 'ml-2',
                    'active'  => ['kunjungan', 'kunjungan/create', 'regex:@^kunjungan(\/[0-9]+)?+$@', 'regex:@^kunjungan(\/[0-9]+)?\/edit+$@',],
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'E-File Rekam Medis',
                    'icon'    => 'fas fa-diagnoses',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                    'url'  => 'efilerm',
                    // 'active'  => ['efilerm', 'efilerm/create' ,'regex:@^antrian/poliklinik(\/[0-9]+)?+$@', 'regex:@^antrian/poliklinik(\/[0-9]+)?\/edit+$@',  'antrian/poliklinik/create'],
                    'active'  => ['efilerm', 'efilerm/create'],

                ],
                [
                    'text' => 'Tarif Layanan',
                    'icon'    => 'fas fa-hand-holding-medical',
                    'url'  => 'tarif_layanan',
                    'shift'   => 'ml-2',
                    'can' => 'pelayanan-medis',

                ],
                [
                    'text' => 'Obat',
                    'icon'    => 'fas fa-pills',
                    'url'  => 'obat',
                    'shift'   => 'ml-2',
                    'can' => 'farmasi',
                ],
                [
                    'text' => 'Surat Masuk',
                    'icon'    => 'fas fa-envelope',
                    'url'  => 'suratmasuk',
                    'shift'   => 'ml-2',
                    'can' => 'bagian-umum',
                ],
                [
                    'text' => 'Disposisi',
                    'icon'    => 'fas fa-file-signature',
                    'url'  => 'disposisi',
                    'shift'   => 'ml-2',
                    'active'  => ['disposisi', 'disposisi/create', 'regex:@^disposisi(\/[0-9]+)?+$@', 'regex:@^disposisi(\/[0-9]+)?\/edit+$@',],
                    'can' =>  ['bagian-umum', 'direktur'],
                ],
                [
                    'text' => 'Surat Keluar',
                    'icon'    => 'fas fa-envelope',
                    'url'  => 'suratkeluar',
                    'shift'   => 'ml-2',
                    'can' => 'bagian-umum',
                ],
                [
                    'text' => 'Data Pendukung',
                    'icon'    => 'fas fa-book',
                    'url'  => 'data-jabatan',
                    'shift'   => 'ml-2',
                    'can' => 'pegawai',
                ],
                [
                    'text' => 'Jurusan & Kebutuhan',
                    'icon'    => 'fas fa-book',
                    'url'  => 'kebutuhan-jurusan',
                    'shift'   => 'ml-2',
                    'can' => 'pegawai',
                ],
                [
                    'text' => 'Data Pegawai',
                    'icon'    => 'fas fa-book',
                    'url'  => 'data-pegawai',
                    'shift'   => 'ml-2',
                    'can' => 'pegawai',
                ],
                [
                    'text' => 'Pegawai Mutasi',
                    'icon'    => 'fas fa-book',
                    'url'  => 'pegawai-mutasi',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Buku Tamu',
                    'icon'    => 'fas fa-book',
                    'url'  => 'bukutamu',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],

            ],
        ],
        // LAPORAN
        [
            'text'    => 'Hasil & Laporan',
            'icon'    => 'fas fa-file',
            'submenu' => [
                [
                    'text' => 'Hasil Laboratorium',
                    'icon'    => 'fas fa-vials',
                    'url'  => 'hasillaboratorium',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'Hasil Radiologi',
                    'icon'    => 'fas fa-x-ray',
                    'url'  => 'hasilradiologi',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'Hasil Lab Patologi Anatomi',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'hasillabpa',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'Monitoring Resume Ranap',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'monitoring_resume_ranap',
                    'active' => ['monitoring_resume_ranap', 'form_resume_ranap'],
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'Capaian Antrian Pertanggal',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'url'  => 'dashboardTanggalAntrianPoliklinik',
                ],
                [
                    'text' => 'Capaian Antrian Perbulan',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'url'  => 'dashboardBulanAntrianPoliklinik',
                ],
                [
                    'text' => 'Data Tamu',
                    'icon'    => 'fas fa-book',
                    'url'  => 'bukutamu',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Laporan Antrian',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'url'  => 'laporanAntrianPoliklinik',
                    'can' => 'poliklinik',
                ],
                [
                    'text' => 'Laporan Kunjungan',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'url'  => 'laporanKunjunganPoliklinik',
                    'can' => 'poliklinik',
                ],
                [
                    'text' => 'Laporan E-Klaim Ranap',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'url'  => 'laporan_eklaim_ranap',
                    'can' => 'casemix',
                ],
                [
                    'text' => 'Diagnosa Rawat Jalan',
                    'icon'    => 'fas fa-diagnoses',
                    'url'  => 'diagnosaRawatJalan',
                    'shift'   => 'ml-2',
                    'can' => 'casemix',
                ],
                [
                    'text' => 'Pasien Ranap Pulang',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'pasienranappulang',
                    'shift'   => 'ml-2',
                    'can' => 'casemix',
                ],
                [
                    'text' => 'Laporan Kunjungan Poliklinik',
                    'icon'    => 'fas fa-disease',
                    'url'  => 'laporanKunjunganPoliklinik',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'Kunjungan Pasien Ranap',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'kunjunganpasienranap',
                    'shift'   => 'ml-2',
                    'can' => 'casemix',
                ],
                [
                    'text' => 'CPPT',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'cppt',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'Diagnosa Pola Penyakit',
                    'icon'    => 'fas fa-chart-bar',
                    'shift'   => 'ml-2',
                    'can' => ['k3rs', 'rekam-medis'],
                    'submenu' => [
                        [
                            'text' => 'Pola Penyakit Penderita Rawat Inap',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'rawat-inap/diagnosa-pola-penyakit',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Pola Penyakit Penderita Rawat Jalan',
                            'icon'    => 'fas fa-disease',
                            'url'  => '/rawat-jalan/diagnosa-pola-penyakit',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                    ]
                ],
                [
                    'text' => 'Laporan Index',
                    'icon'    => 'fas fa-chart-bar',
                    'shift'   => 'ml-2',
                    'can' => ['k3rs', 'rekam-medis'],
                    'submenu' => [
                        [
                            'text' => 'Index Penyakit Rawat Jalan',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'LaporanPenyakitRawatJalan',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Index Rawat Jalan (Penelitian)',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'LaporanPenyakitRawatJalanbyYears',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Index Penyakit Rawat Inap',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'LaporanPenyakitRawatInap',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Index Rawat Inap (Penelitian)',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'LaporanPenyakitRawatInapbyYears',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Diagnosa Survailans Rawat Inap',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'LaporanDiagnosaSurvailansInap',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Diagnosa Survailans Rawat Jalan',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'LaporanDiagnosaSurvailansRawatJalan',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        // [
                        //     'text' => 'Index Dokter',
                        //     'icon'    => 'fas fa-user-md',
                        //     'url'  => 'index_dokter',
                        //     'shift'   => 'ml-3',
                        //     'can' => ['k3rs','rekam-medis'],
                        // ],
                        // [
                        //     'text' => 'Index Daerah',
                        //     'icon'    => 'fas fa-maps',
                        //     'url'  => 'index_daerah',
                        //     'shift'   => 'ml-3',
                        //     'can' => ['k3rs','rekam-medis'],
                        // ],
                    ]
                ],
                // Formulir RL
                [
                    'text' => 'Formulir RL 1',
                    'icon'    => 'fas fa-chart-bar',
                    'shift'   => 'ml-2',
                    'can' => ['k3rs', 'rekam-medis'],
                    'submenu' => [
                        [
                            'text' => 'Formulir RL 1',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL1',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 1.1',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL1',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 1.2',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL1',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 1.3',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL1',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                    ]
                ],
                [
                    'text' => 'Formulir RL 2',
                    'icon'    => 'fas fa-disease',
                    'url'  => 'FormulirRL2',
                    'shift'   => 'ml-2',
                    'can' => ['k3rs', 'rekam-medis'],
                ],
                [
                    'text' => 'Formulir RL 3',
                    'icon'    => 'fas fa-chart-bar',
                    'shift'   => 'ml-2',
                    'can' => ['k3rs', 'rekam-medis'],
                    'submenu' => [
                        [
                            'text' => 'Formulir RL 3',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL3',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 3.1',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL3',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 3.2',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL3',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 3.3',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL3',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 3.4',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL3',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 3.5',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL3',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 3.6',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL3',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 3.7',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL3',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 3.8',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL3',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 3.9',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL3',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 3.10',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL3',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                    ]
                ],
                [
                    'text' => 'Formulir RL 4',
                    'icon'    => 'fas fa-chart-bar',
                    'shift'   => 'ml-2',
                    'can' => ['k3rs', 'rekam-medis'],
                    'submenu' => [
                        [
                            'text' => 'RL4A Rawat Inap',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL4A',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'RL4A Rawat Inap Kecelakaan',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL4AK',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'RL4B Rawat Jalan',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL4B',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'RL4B Rawat Jalan Kecelakaan',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL4BK',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                    ]
                ],
                [
                    'text' => 'Formulir RL 5',
                    'icon'    => 'fas fa-chart-bar',
                    'shift'   => 'ml-2',
                    'can' => ['k3rs', 'rekam-medis'],
                    'submenu' => [
                        [
                            'text' => 'Formulir RL 5.1',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL1',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 5.2',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL1',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 5.3',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL5_3',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 5.4',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL5_4',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Formulir RL 5.5',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL5_5',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                    ]
                ],
            ],
        ],
        // ANTRIAN BPJS
        [
            'text'    => 'Integrasi Antrian BPJS',
            'icon'    => 'fas fa-project-diagram',
            'can' => ['bpjs', 'pendaftaran'],
            'submenu' => [
                [
                    'text' => 'Status Bridging',
                    'icon'    => 'fas fa-info-circle',
                    'url'  => 'statusAntrianBpjs',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Poliklinik',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'poliklikAntrianBpjs',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Dokter',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'dokterAntrianBpjs',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Jadwal Dokter',
                    'icon'    => 'fas fa-calendar-alt',
                    'url'  => 'jadwalDokterAntrianBpjs',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Cek Fingerprint Peserta',
                    'icon'    => 'fas fa-fingerprint',
                    'url'  => 'fingerprintPeserta',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Console Antrian',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'antrianBpjsConsole',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Antrian',
                    'icon'    => 'fas fa-hospital-user',
                    'url'  => 'antrianBpjs',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'List Task',
                    'icon'    => 'fas fa-user-clock',
                    'url'  => 'listTaskID',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Dasboard Tanggal',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'dashboardTanggalAntrian',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Dashboard Bulan',
                    'icon'    => 'fas fa-calendar-week',
                    'url'  => 'dashboardBulanAntrian',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Jadwal Operasi',
                    'icon'    => 'fas fa-calendar-alt',
                    'url'  => 'jadwalOperasi',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Antrian Per Tanggal',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'antrianPerTanggal',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Antrian Per Kodebooking',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'antrianPerKodebooking',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Antrian Belum  Dilayani',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'antrianBelumDilayani',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Antrian Per Dokter',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'antrianPerDokter',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],

            ],
        ],
        // VCLAIM BPJS
        [
            'text'    => 'Integrasi VClaim BPJS',
            'icon'    => 'fas fa-project-diagram',
            'can' => ['bpjs', 'pendaftaran'],
            'submenu' => [
                [
                    'text' => 'Lembar Pengajuan Klaim',
                    'icon'    => 'fas fa-id-card',
                    'url'  => 'vclaim/lpk',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Monitoring',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'submenu' => [
                        [
                            'text' => 'Data Kunjungan',
                            'icon'    => 'fas fa-chart-bar',
                            'url'  => 'monitoringDataKunjungan',
                            'shift'   => 'ml-3',
                            'can' => ['bpjs', 'pendaftaran'],
                        ],
                        [
                            'text' => 'Data Klaim',
                            'icon'    => 'fas fa-chart-pie',
                            'url'  => 'monitoringDataKlaim',
                            'shift'   => 'ml-3',
                            'can' => ['bpjs', 'pendaftaran'],
                        ],
                        [
                            'text' => 'Monitoring Pelayanan Peserta',
                            'icon'    => 'fas fa-id-card',
                            'url'  => 'monitoringPelayananPeserta',
                            'shift'   => 'ml-3',
                            'can' => ['bpjs', 'pendaftaran'],
                        ],
                        [
                            'text' => 'Data Klaim Jasa Raharja',
                            'icon'    => 'fas fa-chart-area',
                            'url'  => 'monitoringKlaimJasaraharja',
                            'shift'   => 'ml-3',
                            'can' => ['bpjs', 'pendaftaran'],
                        ],
                    ]

                ],
                [
                    'text' => 'PRB',
                    'icon'    => 'fas fa-first-aid',
                    'url'  => 'vclaim/prb',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Referensi',
                    'icon'    => 'fas fa-info-circle',
                    'url'  => 'referensiVclaim',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Surat Kontrol & SPRI',
                    'icon'    => 'fas fa-id-card',
                    'url'  => 'suratKontrolBpjs',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Rujukan',
                    'icon'    => 'fas fa-id-card',
                    'url'  => 'rujukanBpjs',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'SEP',
                    'icon'    => 'fas fa-chart-line',
                    'shift'   => 'ml-2',
                    'submenu' => [
                        [
                            'text' => 'Data SEP Internal',
                            'icon'    => 'fas fa-id-card',
                            'url'  => 'sep_internal',
                            'shift'   => 'ml-3',
                            'can' => ['bpjs', 'pendaftaran'],
                        ],
                    ]

                ],

            ],
        ],
        // VCLAIM BPJS
        [
            'text'    => 'Integrasi Satu Sehat',
            'icon'    => 'fas fa-project-diagram',
            'can' => ['bpjs', 'pendaftaran', 'rekam-medis'],
            'submenu' => [
                [
                    'text' => 'Token',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'satusehat/token_generate',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'casemix', 'rekam-medis'],
                ],
                [
                    'text' => 'Patient',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'satusehat/patient',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'casemix', 'rekam-medis'],
                ],
                [
                    'text' => 'Practitioner',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'satusehat/practitioner',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'casemix', 'rekam-medis'],
                ],
                [
                    'text' => 'Organization',
                    'icon'    => 'fas fa-hospital',
                    'url'  => 'satusehat/organization',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'casemix', 'rekam-medis'],
                ],
                [
                    'text' => 'Location',
                    'icon'    => 'fas fa-hospital',
                    'url'  => 'satusehat/location',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'casemix', 'rekam-medis'],
                ],
                [
                    'text' => 'Encounter',
                    'icon'    => 'fas fa-user',
                    'url'  => 'satusehat/encounter',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'casemix', 'rekam-medis'],
                ],
                [
                    'text' => 'Condition',
                    'icon'    => 'fas fa-user',
                    'url'  => 'satusehat/pient',
                    'shift'   => 'ml-2',
                    'can' => ['bpjs', 'pendaftaran', 'casemix', 'rekam-medis'],
                ],
            ],
        ],
        // MODUL TESTING
        [
            'text'    => 'Pengaturan & Testing',
            'icon'    => 'fas fa-cogs',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'Bar & QR Code Scanner',
                    'icon'    => 'fas fa-qrcode',
                    'url'  => 'cekBarQRCode',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Thermal Printer',
                    'icon'    => 'fas fa-print',
                    'url'  => 'cekThermalPrinter',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'WhatsApp API',
                    'icon'    => 'fas fa-phone',
                    'url'  => 'whatsapp',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text'        => 'Log Viewer',
                    'url'         => 'log-viewer',
                    'icon'        => 'fas fa-info-circle',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
            ],
        ],
        // USER ACCESS CONTROLL
        [
            'text'    => 'User Access Control',
            'icon'    => 'fas fa-users-cog',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'User',
                    'icon'    => 'fas fa-users',
                    'url'  => 'user',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                    'active'  => ['user', 'user/create', 'regex:@^user(\/[0-9]+)?+$@', 'regex:@^user(\/[0-9]+)?\/edit+$@',],
                ],
                [
                    'text' => 'Role & Permission',
                    'icon'    => 'fas fa-user-shield',
                    'url'  => 'role',
                    'shift'   => 'ml-2',
                    'active'  => ['role', 'role/create', 'regex:@^role(\/[0-9]+)?+$@', 'regex:@^role(\/[0-9]+)?\/edit+$@', 'regex:@^permission(\/[0-9]+)?\/edit+$@'],
                    'can' => 'admin',
                ],
            ],
        ],
        [
            'text' => 'profile',
            'url'  => 'profile',
            'icon' => 'fas fa-fw fa-user',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'BsCustomFileInput' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bs-custom-file-input/bs-custom-file-input.min.js',
                ],
            ],
        ],
        'TempusDominusBs4' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
                ],
            ],
        ],
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'DatatablesPlugins' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.html5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.print.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/jszip/jszip.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/pdfmake.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/vfs_fonts.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css',
                ],
            ],
        ],
        'DatatablesFixedColumns' => [
            'active' => false,
            'files' => [
                // [
                //     'type' => 'js',
                //     'asset' => true,
                //     'location' => 'vendor/datatables-plugins/fixedcolumns/js/fixedColumns.bootstrap4.min.js',
                // ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/fixedcolumns/js/dataTables.fixedColumns.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/fixedcolumns/css/fixedColumns.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/chart.js/Chart.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/chart.js/Chart.min.css',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.all.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                ],
            ],
        ],
        'BootstrapSwitch' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-switch/js/bootstrap-switch.min.js',
                ],
            ],
        ],
        'Pace' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/pace-progress/themes/blue/pace-theme-flat-top.css'
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/pace-progress/pace.min.js'
                ],
            ],
        ],
        'DateRangePicker' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' =>  'vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/daterangepicker/daterangepicker.css',
                ],
            ],
        ],
        'EkkoLightBox' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' =>  'vendor/ekko-lightbox/ekko-lightbox.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' =>  'vendor/ekko-lightbox/ekko-lightbox.css',
                ],
            ],
        ],
        'BsCustomFileInput' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bs-custom-file-input/bs-custom-file-input.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
