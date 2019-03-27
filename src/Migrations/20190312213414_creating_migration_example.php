<?php
/**
 * @author Giuseppe Fechio <giuseppe.fechio@gmail.com>
 */


use Zepp\Phinx\Migration;
use Zepp\Phinx\IBaseMigration;

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
