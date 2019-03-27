<?php
/**
 * @author Giuseppe Fechio <giuseppe.fechio@endurance.com>
 */

/**
 * Interface IBaseMigration
 */
interface IBaseMigration
{
    /**
     * @return mixed
     */
    public function up();

    /**
     * @return mixed
     */
    public function down();

}