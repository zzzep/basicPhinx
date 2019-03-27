<?php
/**
 * @author Giuseppe Fechio <giuseppe.fechio@gmail.com>
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