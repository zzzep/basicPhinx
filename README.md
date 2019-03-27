## How to Use

Run composer to install phinx 
```bash
composer install ; composer update
```

Just create, edit, run and rollback

## Commands

To create New Migration:
 
```Bash
  php vendor/bin/phinx create MyNewMigration -c migration.php
```

That will show you the created File

EX:
```
Phinx by CakePHP - https://phinx.org. 0.10.6

using config file ./migration.php
using config parser php
using migration paths 
 - ~/{PATH_MIGRATION}
using migration base class {NAMESPACE_MIGRATION}
using default template
created src/Migrations/20190308222306_my_new_migration.php
```

Just edit file `src/Migrations/20190308222306_my_new_migration.php`

#### Migrating

To run migration (ALL not migrated):
```bash
 php vendor/bin/phinx migrate -c migration.php
```

To rollback migration (last migration):
```bash
 # php vendor/bin/phinx rollback -c migration.php -- BE CAREFUL
```

Example Migration File
```PHP
<?php
/**
 * @author Giuseppe Fechio <giuseppe.fechio@endurance.com>
 */

class CreatingMigrationExample extends Migration implements IBaseMigration
{
    protected $tableName = 'example_migration';

    public function up()
    {

        /**
         * Creating new table
         */
        // Auto-increment id (will be primary key if none used)
        $table = $this->table($this->tableName);
        /**
         * to specify primary key :
         * $table = $this->table($this->tableName,['id'=>'my_primary_key_with_auto_increment']);
         */
        $table->addColumn("rel_id",'integer')
            ->addColumn("name",'string')
            // Required for Eloquent's created_at and updated_at columns
            ->addTimestamps()
            // Add Comment
            ->changeComment("Table to know if hosting use new sites creation flow")
            ->create();

        /**
         * OBS: use only one action per migration
         * EX:
         *  * 1 migration to only create table
         *  * 1 migration to only add column
         *  * 1 migration to only change column
         *  * 1 migration to only insert records
         */

        //Example to create new column
        $this->table($this->tableName)
            ->addColumn('description', 'text', [
                'after' => 'name'
            ])
            ->save();

        //Example to create new columns with default
        $this->table($this->tableName)
            ->addColumn('i_am_new_column', 'boolean', [
                'default' => true,
                'after' => 'description',
                'null' => true
            ])
            ->addColumn('i_am_a_date', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'after' => 'i_am_new_column'
            ])
            ->save();

        //Example to insert record
        $this->table($this->tableName)
            ->insert([
                'rel_id' => 3,
                'name' => "My Poc"
            ])
            ->save();

    }

    public function down()
    {
        $this->table($this->tableName)->drop()->save();
    }
}




```

### Flow

- Create Migration
  - In root path
  - `php vendor/bin/phinx create WhatMyMigrationWillDoInCamelCase -c migration.php`
  - Create migration with single responsibility
- Edit Migration File
  - Use method up() to migration
  - Use method down() to rollback
  - Example above
- Running Migration In DEV
  - `php vendor/bin/phinx migrate -c migration.php`
- Running Migration In Test
  - `php vendor/bin/phinx migrate -c migration.php`
- **Before deploy rename migration version to current timestamp**
- In case of rollback
  - `php vendor/bin/phinx rollback -c migration.php -d {VERSION}`
  

### Run/Rollback by dates

Migration **to** Specific dates 
```bash
  php vendor/bin/phinx migrate -c migration.php -d 20190308193425
  php vendor/bin/phinx migrate -c migration.php -d 201903081934
  php vendor/bin/phinx migrate -c migration.php -d 2019030819
  php vendor/bin/phinx migrate -c migration.php -d 20190308
```

Rollback **until** specific dates
```bash
  php vendor/bin/phinx rollback -c migration.php -d 20190308193425
  php vendor/bin/phinx rollback -c migration.php -d 201903081934
  php vendor/bin/phinx rollback -c migration.php -d 2019030819
  php vendor/bin/phinx rollback -c migration.php -d 20190308
```

*OBS:* 
> When rollback to date `20190308193425` the version `20190308193425` will not be rollbacked .
> To rollback this version too can use one second before (`20190308193424`)
  
### Run/Rollback by versions

Migration **to** Specific version 
```bash
  php vendor/bin/phinx migrate -c migration.php -t 20190308193425
```

Rollback **until** specific version
```bash
  php vendor/bin/phinx rollback -c migration.php -t 20190308193425
```

*OBS:*

> when rollback to version `20190308193425` the version `20190308193425` will not be rollbacked.
> To rollback this version you have to use last version before `20190308193425`

### Using Dry Run
* `--Dry-run` just show which queries will be executed, and don't execute them

Command Example:
```bash
php vendor/bin/phinx migrate -c migration.php --dry-run
```

Output Example:
```
Phinx by CakePHP - https://phinx.org. 0.10.6

using config file ./migration.php
using config parser php
using migration paths 
 - {PATH_MIGRATION}
warning no environment specified, defaulting to: base
using adapter mysql
using database whmcs_br

 == 20190312213414 CreatingMigrationExample: migrating
START TRANSACTION
CREATE TABLE `example_migration` (`id` INT(11) NOT NULL AUTO_INCREMENT, `rel_id` INT(11) NOT NULL, `name` VARCHAR(255) NOT NULL, `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, `updated_at` TIMESTAMP NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB CHARACTER SET latin1 COLLATE latin1_swedish_ci;
ALTER TABLE `example_migration`  COMMENT='Table to know if hosting use new sites creation flow' 
CREATE TABLE `example_migration` (`id` INT(11) NOT NULL AUTO_INCREMENT, `description` TEXT NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB CHARACTER SET latin1 COLLATE latin1_swedish_ci;
CREATE TABLE `example_migration` (`id` INT(11) NOT NULL AUTO_INCREMENT, `i_am_new_column` TINYINT(1) NULL DEFAULT 1, `i_am_a_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE = InnoDB CHARACTER SET latin1 COLLATE latin1_swedish_ci;
CREATE TABLE `example_migration` (`id` INT(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`)) ENGINE = InnoDB CHARACTER SET latin1 COLLATE latin1_swedish_ci;
INSERT INTO `example_migration` (`rel_id`, `name`) VALUES (3, 'My Poc');
COMMIT
INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES ('20190312213414', 'CreatingMigrationExample', '2019-03-27 12:18:45', '2019-03-27 12:18:45', 0);
 == 20190312213414 CreatingMigrationExample: migrated 0.0061s

All Done. Took 0.0167s

```

### Known Bugs
- Do NOT use Schema method
  - Parameter `--dry-run` not works pretty well with `schema`
    - Expected: 
      - Just show queries 
      - Not running queries
    - Observed: 
      - Showing almost all queries (not show queries with schema) 
      - Running query with schema
    

 [More About Phinx](http://docs.phinx.org/en/latest/).
