<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 1.7.2016
 * Time: 15:25
 */
class StaredManager
{
    /**
     * spocita vsechny cisla a udela procentni vysledek
     * @param $table
     * @param $url
     * @return float
     */
    public function percentSum($table, $url)
    {
        $data =Database::oneQuery("SELECT `value_Star`, `count_star` FROM `$table` WHERE `urlArticle` = ?", array($url));
        $countRows = $data['count_star'];
        $total = $data['value_Star'];
        if($countRows !=0) {
            $totalPrecent = ($total / $countRows) * 20;
        }
        else
            $totalPrecent = 0;
        return $totalPrecent;
    }


    public function returnData($table, $url)
    {
        return Database::oneQuery("SELECT * FROM `$table` WHERE `urlArticle` = ?", array($url));
    }

    public function updateDataAndRefresh($table, $params = array(), $if, $paramsIf= array())
    {
        Database::change($table,$params, $if,$paramsIf);
    }


}