<?php

return [
    'temporary_file_upload' => [
        'disk' => 'local',
        'rules' => ['file', 'max:12288'], // 12MB Max
        'directory' => 'livewire-tmp',
        'middleware' => 'throttle:60,1',
    ],
];
