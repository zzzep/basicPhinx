<?php

return [
    'paths' => [
        'migrations' => './src/Migrations'
    ],
    'migration_base_class' => 'Zepp\Phinx\Migration',
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