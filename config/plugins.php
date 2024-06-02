<?php
use Cake\Core\Configure;

Configure::write('DebugKit.safeTld', [
    'dev',
    'local',
    'example',
    'com',
]);

return [
    'DebugKit' => [],
    'Bake' => [
        'onlyCli' => true,
        'optional' => true,
    ],
    'Migrations' => [
        'onlyCli' => true,
    ],
];
