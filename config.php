<?php

return [
    'paths' => [
        'migrations' => '.'
    ],
    'migration_base_class' => '',
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'base',
        'base' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'database',
            'user' => 'root',
            'pass' => '',
            'port' => 3306
        ]
    ]
];