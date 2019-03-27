<?php
/**
 * @author Giuseppe Fechio <giuseppe.fechio@gmail.com>
 */

namespace Zepp\Phinx;

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