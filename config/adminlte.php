<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section
    | like so: @section('title', 'Dashboard | My Great Admin Panel')
    |
    */

    'title' => 'Suprema',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Suprema</b>BS',

    'logo_mini' => '<b></b>BS',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | first two must respond to a GET request, the last two to a POST.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => '/',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header.
    |
    */
    /*
    'menu' => [

        'Admin',
            [
                'text' => 'Configurations',
                'icon' => 'dashboard',
                'submenu' => 
                [
                    [
                        'text' => 'Users',
                        'url' => '/editUserPermissions',
                        'icon' => 'user'
                    ],
                    [
                        'text' => 'Permissions',
                        'url' => '/editPermissions',
                        'icon' => 'lock'
                    ],
                    [
                        'text' => 'Departments',
                        'url' => '/Department/index',
                        'icon' => 'table',
                    ],
                    [
                        'text' => 'Shifts',
                        'url' => '/Shift/index',
                        'icon' => 'table',
                    ],
                    [
                        'text' => 'Leaves',
                        'url' => '/Leave/index',
                        'icon' => 'table',
                    ],
                    [
                        'text' => 'Bonuses',
                        'url' => '/Bonus/index',
                        'icon' => 'table',
                    ],
                    [
                        'text' => 'Calendar',
                        'url' => '/Calendar/view',
                        'icon' => 'calendar',
                    ],
                    [
                        'text' => 'Employees',
                        'url' => '/Employee/index',
                        'icon' => 'user',
                    ],
                ],
            ],
            [
                'text' => 'Attendence',
                'submenu' => 
                [
                    [
                        'text' => 'Abscents',
                        'url' => '/Abscent/index/0',
                        'icon_color' => 'red',
                    ],
                    [
                        'text' => 'Approved Abscents',
                        'url' => '/Abscent/index/1',
                        'icon_color' => 'yellow',
                    ],
                    [
                        'text' => 'Overtime',
                        'url' => '/Overtime/index/0',
                        'icon_color' => 'aqua',
                    ],
                    [
                        'text' => 'Approved Overtime',
                        'url' => '/Overtime/index/1',
                        'icon_color' => 'green',
                    ],
                ],
            ],
        'Logs',
        [
            'text' => 'Reports',
            'icon' => 'file',
            'submenu' => 
            [
                [
                    'text' => 'Attendence',
                    'url' => '/AttendenceLog/index',
                    'icon' => 'th',
                ],
                [
                    'text' => 'System',
                    'url' => '/log',
                    'icon' => 'th',
                ],
                [
                    'text' => 'Generate Reports',
                    'url' => '/Report',
                    'icon' => 'file',
                ],
            ],
        ],
    ],
    */
        'menu' => [

        'Admin',
            [
                'text' => 'اللإعدادات',
                'icon' => 'dashboard',
                'submenu' => 
                [
                    [
                        'text' => 'المستخدمين',
                        'url' => '/editUserPermissions',
                        'icon' => 'user'
                    ],
                    [
                        'text' => 'الصلاحيات',
                        'url' => '/editPermissions',
                        'icon' => 'lock'
                    ],
                    [
                        'text' => 'الأقسام',
                        'url' => '/Department/index',
                        'icon' => 'table',
                    ],
                    [
                        'text' => 'ألورديات',
                        'url' => '/Shift/index',
                        'icon' => 'table',
                    ],
                    [
                        'text' => 'الإجازات',
                        'url' => '/Leave/index',
                        'icon' => 'table',
                    ],
                    [
                        'text' => 'المكافاّت',
                        'url' => '/Bonus/index',
                        'icon' => 'table',
                    ],
                    [
                        'text' => 'التقويم',
                        'url' => '/Calendar/view',
                        'icon' => 'calendar',
                    ],
                    [
                        'text' => 'الموظفين',
                        'url' => '/Employee/index',
                        'icon' => 'user',
                    ],
                ],
            ],
            [
                'text' => 'الحضور',
                'submenu' => 
                [
                    [
                        'text' => 'الغيابات',
                        'url' => '/Abscent/index/0',
                        'icon_color' => 'red',
                    ],
                    [
                        'text' => 'الغيابات الموافق عليها',
                        'url' => '/Abscent/index/1',
                        'icon_color' => 'yellow',
                    ],
                    [
                        'text' => 'الاضافي',
                        'url' => '/Overtime/index/0',
                        'icon_color' => 'aqua',
                    ],
                    [
                        'text' => 'الاضافي الموافق عليها',
                        'url' => '/Overtime/index/1',
                        'icon_color' => 'green',
                    ],
                ],
            ],
        'سجل الحقول المرجعية',
        [
            'text' => 'التقارير',
            'icon' => 'file',
            'submenu' => 
            [
                [
                    'text' => 'الحضور',
                    'url' => '/AttendenceLog/index',
                    'icon' => 'th',
                ],
                [
                    'text' => 'النظام',
                    'url' => '/log',
                    'icon' => 'th',
                ],
                [
                    'text' => 'مولد التقارير',
                    'url' => '/Report',
                    'icon' => 'file',
                ],
            ],
        ],
    ],
];
