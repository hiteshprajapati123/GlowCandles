<?php

return [
    'default' => env('FILAMENT_FILESYSTEM_DISK', 'public'),
    'disks' => [
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],
    ],
    'navigation' => [
        'groups' => [
            [
                'id' => 'user_management',
                'label' => 'User Management',
                'sort' => 1,
            ],
            [
                'id' => 'catalog',
                'label' => 'Catalog',
                'sort' => 2,
            ],
            [
                'id' => 'orders',
                'label' => 'Orders',
                'sort' => 3,
            ],
            [
                'id' => 'additional_features',
                'label' => 'Additional Features',
                'sort' => 4,
            ],
            [
                'id' => 'payments',
                'label' => 'Payments',
                'sort' => 5,
            ],
            [
                'id' => 'pages',
                'label' => 'Pages',
                'sort' => 6,
            ],
        ],
    ],
];
