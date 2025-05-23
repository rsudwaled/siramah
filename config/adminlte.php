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
        'allowed' => false,
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
    'classes_content_wrapper' => 'text-xs',
    'classes_content_header' => 'text-xs',
    'classes_content' => 'text-xs',
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
        // [
        //     'text'        => 'Resume Pemulangan',
        //     'url'         => 'resume-pemulangan.vbeta/pasien-rawat-inap',
        //     'icon'        => 'fas fa-file-signature',
        // ],
        // PELAYANAN
        [
            'text'    => 'Pelayanan Rawat Jalan',
            'icon'    => 'fas fa-clinic-medical',
            'label' => 'proses',
            'label_color' => 'warning',
            'submenu' => [
                [
                    'text' => 'Anjungan Mandiri',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'anjungan-mandiri',
                    'active'  => ['anjungan-mandiri'],
                    'shift'   => 'ml-2',
                    'can' => ['pendaftaran'],
                ],
                [
                    'text' => 'Display Antrian Lt 2',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'displayantrianklinik/2',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Display Antrian Lt 3',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'displayantrianklinik/3',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Display Farmasi Lt 2',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'displayantrianfarmasi/2',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Display Jadwal Rajal',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'display-jadwal-rajal',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Pendaftaran Rawat Jalan',
                    'icon'    => 'fas fa-user-plus',
                    'url'  => 'pendaftaran-rajal',
                    'active'  => ['pendaftaran-rajal', 'pendaftaran-rajal-proses'],
                    'shift'   => 'ml-2',
                    'can' => ['pendaftaran'],
                ],
                [
                    'text' => 'Kunjungan Poliklinik',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'kunjungan-poliklinik',
                    'active'  => ['kunjungan-poliklinik', 'kunjungan-poliklinik-pasien'],
                    'shift'   => 'ml-2',
                    'can' => 'poliklinik',
                ],
                [
                    'text' => 'Antrian Perawat',
                    'icon'    => 'fas fa-user-plus',
                    'url'  => 'antrian-dokter-rajal',
                    'shift'   => 'ml-2',
                    'label' => 'proses',
                    'label_color' => 'warning',
                ],
                [
                    'text' => 'Antrian Dokter',
                    'icon'    => 'fas fa-user-plus',
                    'url'  => 'antrian-dokter-rajal',
                    'shift'   => 'ml-2',
                    'label' => 'proses',
                    'label_color' => 'warning',
                ],
                [
                    'text' => 'Antrian Farmasi',
                    'icon'    => 'fas fa-pills',
                    'url'  => 'antrian-farmasi-rajal',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Rekam Medis Rawat Jalan',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'rekam-medis-rajal',
                    'active'  => ['rekam-medis-rajal', 'rekam-medis-rajal-detail'],
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Casemix Rawat Jalan',
                    'icon'    => 'fas fa-diagnoses',
                    'url'  => 'casemix-rajal',
                    'active'  => ['casemix-rajal', 'casemix-rajal-detail'],
                    'shift'   => 'ml-2',
                    'label' => 'proses',
                    'label_color' => 'warning',
                ],
                [
                    'text' => 'Dashboard Antrian Rajal',
                    'icon'    => 'fas fa-chart-bar',
                    'url'  => 'dashboard-antrian-rajal',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Monitoring Antrian Rajal',
                    'icon'    => 'fas fa-chart-bar',
                    'url'  => 'monitoring-antrian-rajal',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Monitoring Waktu Antrian',
                    'icon'    => 'fas fa-chart-bar',
                    'url'  => 'monitoring-waktu-antrian',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Monitoring Waktu Antrian',
                    'icon'    => 'fas fa-chart-bar',
                    'url'  => 'monitoring-waktu-antrian-bulan',
                    'shift'   => 'ml-2',
                ],
            ]
        ],
        // PELAYANAN
        [
            'text'    => 'Pelayanan Operasi',
            'icon'    => 'fas fa-clinic-medical',
            'submenu' => [
                [
                    'text' => 'Kunjungan Pasien',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'kunjungan-pasien-operasi',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Laporan Pasien Operasi',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'laporan-pasien-operasi',
                    'active' => ['laporan-pasien-operasi', 'erm-operasi'],
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Jadwal Operasi',
                    'icon'    => 'fas fa-calendar-alt',
                    'url'  => 'jadwal-operasi',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Display Jadwal Operasi',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'jadwaloperasi_display',
                    'shift'   => 'ml-2',
                ],
            ]
        ],
        [
            'text'    => 'Aplikasi Pelayanan',
            'icon'    => 'fas fa-clinic-medical',
            'submenu' => [
                [
                    'text' => 'Anjungan Antrian',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'antrianConsole',
                    'shift'   => 'ml-2',
                    'can' => ['pendaftaran'],
                ],
                [
                    'text' => 'Anjungan Checkin Antrian',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'checkinAntrian',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Display Antrian Farmasi',
                    'icon'    => 'fas fa-desktop',
                    'url'  => 'displayAntrianFarmasi',
                    'shift'   => 'ml-2',
                    'can' =>  ['bpjs', 'pendaftaran'],
                ],
                [
                    'text' => 'Antrian Pendaftaran',
                    'icon'    => 'fas fa-user-plus',
                    'url'  => 'antrianPendaftaran',
                    'shift'   => 'ml-2',
                    'can' => ['pendaftaran'],
                ],
                [
                    'text' => 'Antrian Pembayaran',
                    'icon'    => 'fas fa-hand-holding-usd',
                    'url'  => 'antrian/pembayaran',
                    'shift'   => 'ml-2',
                    'can' => 'kasir',
                ],
                [
                    'text' => 'Pasien Rawat Jalan',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'kunjunganrajal',
                    'shift'   => 'ml-2',
                    'active' => ['kunjunganrajal', 'ermrajal'],
                    'can' => 'poliklinik',
                ],
                [
                    'text' => 'Monitoring Antrian Rajal',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'monitoringAntrianRajal',
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
                    'text' => 'Pasien Rawat Inap',
                    'icon'    => 'fas fa-procedures',
                    'url'  => 'kunjunganranap',
                    'active' => ['kunjunganranap', 'pasienranapprofile'],
                    'shift'   => 'ml-2',
                    'can' => ['ranap', 'rekam-medis'],
                ],
                [
                    'text'  => 'Gizi',
                    'icon'  => 'fas fa-user-injured',
                    'url'   => 'gizi',
                    'shift'   => 'ml-2',
                    // 'can' => 'ranap',
                ],
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
                    'text' => 'Pencarian Pasien',
                    'icon'    => 'fas fa-search',
                    'url'  => 'pencarian\pasien-terdaftar',
                    'shift'   => 'ml-2',
                    'can' => 'pendaftaran-igd',
                ],
                [
                    'text' => 'PENDAFTARAN',
                    'icon'    => 'fas fa-chalkboard-teacher',
                    'url'  => 'daftar/pasien-igd',
                    'shift'   => 'ml-2',
                    'can' => ['pendaftaran-igd'],
                ],

                [
                    'text' => 'KUNJUNGAN PASIEN',
                    'icon'    => 'fas fa-chalkboard-teacher',
                    'shift'   => 'ml-2',
                    'can' => ['pendaftaran-igd'],
                    'submenu' => [
                        [
                            'text' => 'Kunjungan IGD',
                            'url'  => 'daftar-kunjungan',
                            'shift'   => 'ml-2',
                            'can' => 'pendaftaran-igd',
                        ],
                        [
                            'text' => 'Kunjungan Rawat Inap',
                            'url'  => 'pasien-rawat-inap',
                            'shift'   => 'ml-2',
                            'can' => 'pendaftaran-igd',
                        ],
                        [
                            'text' => 'Kunjungan Penunjang',
                            'url'  => 'kunjungan-penunjang',
                            'shift'   => 'ml-2',
                            'can' => 'pendaftaran-igd',
                        ],
                    ]
                ],
                // [
                //     'text' => 'Pendaftaran IGD',
                //     'icon'    => 'fas fa-chalkboard-teacher',
                //     'shift'   => 'ml-2',
                //     'can' => ['pendaftaran-igd'],
                //     'submenu' => [
                //         [
                //             'text' => 'Daftar Pasien',
                //             'url'  => 'daftar/pasien-igd',
                //             'shift'   => 'ml-2',
                //             'can' => 'pendaftaran-igd',
                //         ],
                //         [
                //             'text' => 'Kunjungan Pasien',
                //             'url'  => 'daftar-kunjungan',
                //             'shift'   => 'ml-2',
                //             'can' => 'pendaftaran-igd',
                //         ],

                //     ]
                // ],
                // [
                //     'text' => 'Pendaftaran Ranap',
                //     'icon'    => 'fas fa-procedures',
                //     'shift'   => 'ml-2',
                //     'can' => ['pendaftaran-igd'],
                //     'submenu' => [
                //         [
                //             'text' => 'Daftar Pasien',
                //             'url'  => 'igd-ranap',
                //             'shift'   => 'ml-2',
                //             'can' => 'pendaftaran-igd',
                //         ],
                //         [
                //             'text' => 'Pasien Ranap terdaftar',
                //             'url'  => 'pasien-rawat-inap',
                //             'shift'   => 'ml-2',
                //             'can' => 'pendaftaran-igd',
                //         ],
                //     ]
                // ],
                // [
                //     'text' => 'Pendaftaran Penunjang',
                //     'icon'    => 'fas fa-chalkboard-teacher',
                //     'shift'   => 'ml-2',
                //     'can' => ['pendaftaran-igd'],
                //     'submenu' => [
                //         [
                //             'text' => 'Daftar Pasien',
                //             'url'  => 'penujang/daftar',
                //             'shift'   => 'ml-2',
                //             'can' => 'pendaftaran-igd',
                //         ],

                //     ]
                // ],
                [
                    'text' => 'Pendaftaran Bayi',
                    'icon'    => 'fas fa-baby',
                    'shift'   => 'ml-2',
                    'can' => ['pendaftaran-igd'],
                    'submenu' => [
                        [
                            'text' => 'Daftar Pasien',
                            'url'  => 'list-kunjungan/kebidanan',
                            'shift'   => 'ml-2',
                            'can' => 'pendaftaran-igd',
                        ],

                    ]
                ],

                [
                    'text' => 'Pasien BPJS PROSES',
                    'icon'    => 'fas fa-thumbtack',
                    'url'  => 'pasien-bpjsproses/list-pasien',
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
                    'text' => 'Pasien Pulang',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'cek-pasien-pulang',
                    'shift'   => 'ml-2',
                    'can' => 'pendaftaran-igd',
                ],
                // [
                //     'text' => 'Pencarian Pasien',
                //     'icon'    => 'fas fa-search',
                //     'url'  => 'pencarian\pasien-terdaftar',
                //     'shift'   => 'ml-2',
                //     'can' => 'pendaftaran-igd',
                // ],
                // [
                //     'text' => 'Daftar Ranap',
                //     'icon'    => 'fas fa-procedures',
                //     'url'  => 'igd-ranap',
                //     'shift'   => 'ml-2',
                //     'can' => 'pendaftaran-igd',
                // ],
                // [
                //     'text' => 'Daftar Pasien',
                //     'icon'    => 'fas fa-chalkboard-teacher',
                //     'url'  => 'daftar/pasien-igd',
                //     'shift'   => 'ml-2',
                //     'can' => 'pendaftaran-igd',
                // ],
                // [
                //     'text' => 'Daftar Pasien Bayi',
                //     'icon'    => 'fas fa-baby',
                //     'url'  => 'list-kunjungan/kebidanan',
                //     'shift'   => 'ml-2',
                //     'can' => 'pendaftaran-igd',
                // ],
                // [
                //     'text' => 'Daftar Penunjang',
                //     'icon'    => 'fas fa-chalkboard-teacher',
                //     'url'  => 'penujang/daftar',
                //     'shift'   => 'ml-2',
                //     'can' => 'pendaftaran-igd',
                // ],
                // [
                //     'text' => 'Kunjungan Pasien',
                //     'icon'    => 'fas fa-address-book',
                //     'url'  => 'daftar-kunjungan',
                //     'shift'   => 'ml-2',
                //     'can' => 'pendaftaran-igd',
                // ],
                // [
                //     'text' => 'Pasien BPJS PROSES',
                //     'icon'    => 'fas fa-thumbtack',
                //     'url'  => 'pasien-bpjsproses/list-pasien',
                //     'shift'   => 'ml-2',
                //     'can' => 'pendaftaran-igd',
                // ],
                // [
                //     'text' => 'List Pasien Ranap',
                //     'icon'    => 'fas fa-procedures',
                //     'url'  => 'pasien-rawat-inap',
                //     'shift'   => 'ml-2',
                //     'can' => 'pendaftaran-igd',
                // ],
                // [
                //     'text' => 'Pasien Kecelakaan',
                //     'icon'    => 'fas fa-ambulance',
                //     'url'  => 'list/pasien-kecelakaan',
                //     'shift'   => 'ml-2',
                //     'can' => 'pendaftaran-igd',
                // ],
                // [
                //     'text' => 'Pasien Pulang',
                //     'icon'    => 'fas fa-user-injured',
                //     'url'  => 'cek-pasien-pulang',
                //     'shift'   => 'ml-2',
                //     'can' => 'pendaftaran-igd',
                // ],
                // // [
                // //     'text' => 'Riwayat Pendaftaran byUser',
                // //     'icon'    => 'fas fa-user-plus',
                // //     'url'  => 'get-kunjungan/by-user',
                // //     'shift'   => 'ml-2',
                // //     'can' => 'pendaftaran-igd',
                // // ],
                // [
                //     'text' => 'Bridging (Validasi)',
                //     'icon'    => 'fas fa-sync',
                //     'url'  => 'bridging-igd/ranap',
                //     'shift'   => 'ml-2',
                //     'can' => 'pendaftaran-igd',
                // ],

            ],
        ],
        [
            'text'      => 'Tracer Pendaftaran',
            'icon'      => 'fas fa-user-astronaut',
            'url'       => 'tracer-pendaftaran',
            'can'       => 'rekam-medis',
        ],
        [
            'text'    => 'Farmasi',
            'icon'    => 'fas fa-clinic-medical',
            'submenu' => [
                [
                    'text' => 'Laporan Pengadaan Farmasi',
                    'icon'    => 'fas fa-pills',
                    'url'  => 'laporan-pengadaan-farmasi',
                    'shift'   => 'ml-2',
                ],
            ]
        ],
        // Casemix
        [
            'text'    => 'Akses Casemix',
            'icon'    => 'fas fa-file-invoice-dollar',
            // 'can' => 'casemix',
            'submenu' => [
                [
                    'text' => 'Data Resume',
                    'icon'    => 'fas fa-receipt',
                    'url'  => 'casemix-resume/data-resume',
                    'shift'   => 'ml-2',
                    'can' => 'casemix',
                ],
                [
                    'text' => 'Cari SEP',
                    'icon'    => 'fas fa-receipt',
                    'url'  => 'casemix-cari-sep',
                    'shift'   => 'ml-2',
                    // 'can' => 'casemix',
                ],

            ],
        ],
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
                    'active'  => ['efilerm', 'efilerm/create'],
                ],
                [
                    'text' => 'Scan File RM',
                    'icon'    => 'fas fa-diagnoses',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                    'url'  => 'scanfilerm',
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
                    'text' => 'Laporan Surat Masuk',
                    'icon'    => 'fas fa-envelope',
                    'url'  => 'laporan-suratmasuk',
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
                    'text' => 'SEP Downloader',
                    'icon'    => 'fas fa-download',
                    'url'  => 'sep-downloader',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
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
                    'text' => 'Lap. Diag C00-C99',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'laporan-rm/diagnosa-C00-C99',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'Pengajuan Akses Resume',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'laporan-rm\pembukaan-form-resume\data-pengajuan',
                    'shift'   => 'ml-2',
                    'can' => 'rekam-medis',
                ],
                [
                    'text' => 'Laporan Rekam Medis',
                    'icon'    => 'fas fa-chart-bar',
                    'shift'   => 'ml-2',
                    'can' => ['rekam-medis'],
                    'submenu' => [
                        [
                            'text' => 'Ranap Peruangan',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'laporan-rm\pasien-ranap\peruangan',
                            'shift'   => 'ml-3',
                            'can' => ['rekam-medis'],
                        ],
                        [
                            'text' => 'Pasien Rujukan FKTP',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'laporan-rm\pasien-rujukan-fktp',
                            'shift'   => 'ml-3',
                            'can' => ['rekam-medis'],
                        ],
                        [
                            'text' => 'Kunjungan Poliklinik',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'laporan-rm\kunjungan\kunjungan-poliklinik',
                            'shift'   => 'ml-3',
                            'can' => ['rekam-medis'],
                        ],

                    ]
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
                    'text'      => 'Penyakit Kasus Baru',
                    'icon'      => 'fas fa-chart-bar',
                    'shift'     => 'ml-2',
                    'can'       => ['rekam-medis'],
                    'submenu'   => [
                        [
                            'text'      => 'Menular (DM)',
                            'icon'      => 'fas fa-disease',
                            'url'       => '/laporan-rm/kasus-baru/menular-dm',
                            'shift'     => 'ml-3',
                            'can'       => ['rekam-medis'],
                        ],
                        [
                            'text'      => 'HYPERTENSI (HT)',
                            'icon'      => 'fas fa-disease',
                            'url'       => '/laporan-rm/kasus-baru/hypertensi',
                            'shift'     => 'ml-3',
                            'can'       => ['rekam-medis'],
                        ],
                        [
                            'text'      => 'PPOK',
                            'icon'      => 'fas fa-disease',
                            'url'       => '/laporan-rm/kasus-baru/ppok',
                            'shift'     => 'ml-3',
                            'can'       => ['rekam-medis'],
                        ],
                        [
                            'text'      => 'Jantung',
                            'icon'      => 'fas fa-disease',
                            'url'       => '/laporan-rm/kasus-baru/jantung',
                            'shift'     => 'ml-3',
                            'can'       => ['rekam-medis'],
                        ],
                        [
                            'text'      => 'Stroke',
                            'icon'      => 'fas fa-disease',
                            'url'       => '/laporan-rm/kasus-baru/stroke',
                            'shift'     => 'ml-3',
                            'can'       => ['rekam-medis'],
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
                            'text' => 'Index Dokter',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'index-dokter',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Index Operasi',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'laporan-index/index-operasi ',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'Index Kematian',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'laporan-index/index-kematian',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
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
                            'text' => 'RL4.1 Versi 6',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL4-1/versi-6',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'RL4.2 Versi 6',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL4-2/versi-6',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => 'RL4.3 Versi 6',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL4-3/versi-6',
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
                            'text' => '5.1 versi 6',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL5_1/versi-6',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => '5.2 versi 6',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL5_2/versi-6',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        [
                            'text' => '5.3 versi 6',
                            'icon'    => 'fas fa-disease',
                            'url'  => 'FormulirRL5_3/versi-6',
                            'shift'   => 'ml-3',
                            'can' => ['k3rs', 'rekam-medis'],
                        ],
                        // [
                        //     'text' => 'Formulir RL 5.1',
                        //     'icon'    => 'fas fa-disease',
                        //     'url'  => 'laporan-rm\laporan-rl-51',
                        //     'shift'   => 'ml-3',
                        //     'can' => ['k3rs', 'rekam-medis'],
                        // ],
                        // [
                        //     'text' => 'Formulir RL 5.2',
                        //     'icon'    => 'fas fa-disease',
                        //     'url'  => 'laporan-rm\laporan-rl-52',
                        //     'shift'   => 'ml-3',
                        //     'can' => ['k3rs', 'rekam-medis'],
                        // ],
                        // [
                        //     'text' => 'Formulir RL 5.3',
                        //     'icon'    => 'fas fa-disease',
                        //     'url'  => 'FormulirRL5_3',
                        //     'shift'   => 'ml-3',
                        //     'can' => ['k3rs', 'rekam-medis'],
                        // ],
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
            'can' => 'bpjs',
            'submenu' => [
                [
                    'text' => 'Poliklinik',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'bpjs/antrian/refpoliklinik',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Dokter',
                    'icon'    => 'fas fa-user-md',
                    'url'  => 'bpjs/antrian/refdokter',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Jadwal Dokter',
                    'icon'    => 'fas fa-calendar-alt',
                    'url'  => 'bpjs/antrian/refjadwaldokter',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Poliklinik Fingerprint',
                    'icon'    => 'fas fa-clinic-medical',
                    'url'  => 'bpjs/antrian/refpoliklinik-fingerprint',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Peserta Fingerprint',
                    'icon'    => 'fas fa-fingerprint',
                    'url'  => 'bpjs/antrian/refpeserta-fingerprint',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                // [
                //     'text' => 'Anjungan Antrian',
                //     'icon'    => 'fas fa-desktop',
                //     'url'  => 'anjunganantrian',
                //     'shift'   => 'ml-2',
                // ],
                // [
                //     'text' => 'Antrian',
                //     'icon'    => 'fas fa-hospital-user',
                //     'url'  => 'antrianBpjs',
                //     'shift'   => 'ml-2',
                // ],
                [
                    'text' => 'List Taskid',
                    'icon'    => 'fas fa-user-clock',
                    'url'  => 'bpjs/antrian/listtaskid',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Dasboard Tanggal',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'bpjs/antrian/dashboardtanggal',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Dashboard Bulan',
                    'icon'    => 'fas fa-calendar-week',
                    'url'  => 'bpjs/antrian/dashboardbulan',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                // [
                //     'text' => 'Jadwal Operasi',
                //     'icon'    => 'fas fa-calendar-alt',
                //     'url'  => 'jadwalOperasi',
                //     'shift'   => 'ml-2',
                // 'can' =>  ['bpjs', 'pendaftaran','manajemen'],
                // ],
                [
                    'text' => 'Antrian Per Tanggal',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'bpjs/antrian/antreantanggal',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Antrian Per Kodebooking',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'bpjs/antrian/antreankodebooking/*',
                    'active'  => ['bpjs/antrian/antreankodebooking/*'],
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Antrian Belum  Dilayani',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'bpjs/antrian/antreanbelumlayani',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Antrian Per Dokter',
                    'icon'    => 'fas fa-calendar-day',
                    'url'  => 'bpjs/antrian/antreandokter',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],

            ],
        ],
        // VCLAIM BPJS
        [
            'text'    => 'Integrasi VClaim BPJS',
            'icon'    => 'fas fa-project-diagram',
            'can' => 'bpjs',
            'submenu' => [
                [
                    'text' => 'Lembar Pengajuan Klaim',
                    'icon'    => 'fas fa-file-contract',
                    'url'  => 'lpk',
                    'can' => 'bpjs',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Data Kunjungan',
                    'icon' => 'fas fa-chart-bar',
                    'url' => 'bpjs/vclaim/monitoring-data-kunjungan',
                    'can' => 'bpjs',
                    'shift' => 'ml-2',
                ],
                [
                    'text' => 'Data Klaim',
                    'icon' => 'fas fa-chart-bar',
                    'url' => 'bpjs/vclaim/monitoring-data-klaim',
                    'can' => 'bpjs',
                    'shift' => 'ml-2',
                ],
                [
                    'text' => 'Data Pelayanan Peserta',
                    'icon' => 'fas fa-id-card',
                    'url' => 'bpjs/vclaim/monitoring-pelayanan-peserta',
                    'shift' => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Monitoring Pelayanan Peserta',
                    'icon' => 'fas fa-id-card',
                    'url' => 'monitoringPelayananPeserta',
                    'shift' => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Data Klaim Jasa Raharja',
                    'icon' => 'fas fa-chart-bar',
                    'url' => 'bpjs/vclaim/monitoring-klaim-jasa-raharja',
                    'can' => 'bpjs',
                    'shift' => 'ml-2',
                ],
                [
                    'text' => 'Peserta BPJS',
                    'icon' => 'fas fa-id-card',
                    'url' => 'bpjs/vclaim/peserta-bpjs',
                    'shift' => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'PRB',
                    'icon'    => 'fas fa-first-aid',
                    'url'  => 'vclaim/prb',
                    'can' => 'bpjs',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Referensi',
                    'icon'    => 'fas fa-info-circle',
                    'url'  => 'bpjs/vclaim/referensi',
                    'can' => 'bpjs',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Surat Kontrol',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'bpjs/vclaim/surat-kontrol',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                // [
                //     'text' => 'Rujukan',
                //     'icon'    => 'fas fa-comment-medical',
                //     'url'  => 'bpjs/vclaim/rujukan',
                //     'shift'   => 'ml-2',
                //     'can' => 'bpjs',
                // ],
                [
                    'text' => 'SEP',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'bpjs/vclaim/sep',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
                [
                    'text' => 'Rujukan Keluar',
                    'icon'    => 'fas fa-file-medical',
                    'url'  => 'bpjs/vclaim/rujukan-keluar',
                    'shift'   => 'ml-2',
                    'can' => 'bpjs',
                ],
            ],
        ],
        // SATU SEHAT
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
        // INACBG SEHAT
        [
            'text'    => 'Integrasi INACBG',
            'icon'    => 'fas fa-project-diagram',
            // 'can' => ['inacbg'],
            'submenu' => [
                [
                    'text' => 'Print Claim',
                    'icon'    => 'fas fa-user-injured',
                    'url'  => 'inacbg/print_claim',
                    'shift'   => 'ml-2',
                    // 'can' => ['inacbg'],
                ],
            ],
        ],
        // MODUL TESTING
        [
            'text'    => 'Pengaturan',
            'icon'    => 'fas fa-cogs',
            'submenu' => [
                [
                    'text' => 'Role & Permission',
                    'icon'    => 'fas fa-user-shield',
                    'url'  => 'role-permission',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Data User',
                    'icon'    => 'fas fa-users',
                    'url'  => 'user',
                    'can' => 'admin',
                    'shift'   => 'ml-2',
                ],
                [
                    'text' => 'Pengaturan Bar & QR Code',
                    'icon'    => 'fas fa-qrcode',
                    'url'  => 'cekBarQRCode',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Pengaturan Thermal Printer',
                    'icon'    => 'fas fa-print',
                    'url'  => 'cekThermalPrinter',
                    'shift'   => 'ml-2',
                    'can' => 'admin',
                ],
                [
                    'text' => 'Pengaturan WhatsApp',
                    'icon'    => 'fab fa-whatsapp',
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
        [
            'text' => 'Profil',
            'url'  => 'profil',
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
        'DatatablesPlugin' => [
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
        // 'DatatablesFixedColumns' => [
        //     'active' => false,
        //     'files' => [
        //         // [
        //         //     'type' => 'js',
        //         //     'asset' => true,
        //         //     'location' => 'vendor/datatables-plugins/fixedcolumns/js/fixedColumns.bootstrap4.min.js',
        //         // ],
        //         [
        //             'type' => 'js',
        //             'asset' => true,
        //             'location' => 'vendor/datatables-plugins/fixedcolumns/js/dataTables.fixedColumns.min.js',
        //         ],
        //         [
        //             'type' => 'css',
        //             'asset' => true,
        //             'location' => 'vendor/datatables-plugins/fixedcolumns/css/fixedColumns.bootstrap4.min.css',
        //         ],
        //     ],
        // ],
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
