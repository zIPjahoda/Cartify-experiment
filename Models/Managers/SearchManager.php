<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 23.5.2016
 * Time: 22:51
 */
class SearchManager
{
    /**
     * napovidani
     * @param $table2
     * @param $query
     * @return mixed
     */
    public function returnSearchText($table2, $query)
    {
        return Database::allQuery("
            SELECT *
            FROM `$table2`
            WHERE nameGame
            LIKE '%{$query}%'
        ");
    }

    /**
     * @param $query
     * @param $table2
     * @return array
     */


}