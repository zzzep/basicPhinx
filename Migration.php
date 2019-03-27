<?php

use Phinx\Migration\AbstractMigration;
use Illuminate\Database\Capsule\Manager as Capsule;

class Migration extends AbstractMigration
{
    /** @var \Illuminate\Database\Capsule\Manager $capsule */
    public $capsule;
    /** @var \Illuminate\Database\Schema\Builder $capsule */
    public $schema;

    public function init()
    {
        $this->capsule = new Capsule();
        $this->capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'tabela',
            'username' => 'root',
            'password' => '',
            'port' => 3306,
            'charset' => 'latin1'
        ]);

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();

    }

    public function table($tableName, $options = [])
    {
        $options['engine'] = 'InnoDB';
        $options['charset'] = 'latin1';
        $options['collation'] = 'latin1_swedish_ci';
        return parent::table($tableName, $options);
    }
}