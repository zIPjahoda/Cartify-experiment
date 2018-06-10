<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 26.4.2016
 * Time: 16:08
 */
class TutorialsManager
{
    /**
     * @param $table string; Tabulka z jake tabulky ma brat data
     * @param $limit int; odkud ma zacit
     * @param $onPage int; Pocet kolik jich chceme na stratn
     * @return mixed
     */
    public function countLimit($table, $limit, $table2)
    {
        return Database::allQuery("
                  SELECT *
                  FROM `$table`
                  INNER JOIN `$table2`
                  ON `$table`.`id` = `$table2`.`id`
                  ORDER BY `$table`.`id` DESC LIMIT $limit"
        );
    }
}