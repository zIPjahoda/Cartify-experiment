<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 7.3.2016
 * Time: 20:22
 */
class ListManager
{

    /**
     * vrati clanky v limitu ktery se nastavi na jakekoliv cislo
     * @param $table
     * @param $params
     * @param $countOnPage
     * @return mixed
     */
    public function returnArticleInLimit($table,$params,$countOnPage, $table2)
    {
        $limit = $this->limit($countOnPage, $params);
         return $countLimit = $this->countLimit($table,$limit,$countOnPage, $table2);

    }

    public function setNumberList($table, $params, $countOnPage)
    {
        $countRows = $this->countRows($table);
         return $list = $this->listNavigate($params, $countRows, $countOnPage );
    }

    /**
     * Cislo odkud zacne brat data v databazi
     * @param $onPage int; pocet clanku na stranku
     * @param $actualPage int; aktualni stranka
     * @return mixed
     */
    private function limit($onPage, $actualPage)
    {
        $limit = $onPage * ($actualPage - 1);
        $this->onPage = $onPage;
        $this->setLimit = $limit;
        return $limit;
    }


    /**
     * vrati pocet radku z dane databaze podle id
     * @param $table string; nazev tabulky v databazi
     * @return mixed
     */
    private function countRows($table){
        return Database::countRows("SELECT `id` FROM `$table`");
    }

    /**
     * na strankovani vrati v limitu a na stranku a ziska radky(clanky) z tabulky
     * @return mixed
     */
    private function countLimit($table, $limit, $onPage, $table2)
    {
        return Database::queryCountLine("
                  SELECT *
                  FROM `$table`
                  INNER JOIN `$table2`
                  ON `$table`.`id` = `$table2`.`id`
                  ORDER BY `$table`.`id` DESC LIMIT :limit, :perpage",$limit,$onPage);
    }

    /**
     * navigace stranky, cisla
     * @param $actualPage
     * @param $countRows
     * @param $onPage
     * @return array
     */
    private function listNavigate($actualPage, $countRows, $onPage)
    {

        for ($i = $actualPage-5; $i < $actualPage+5; $i++) {
            if($i < 0)
            {
                while($i < 1){
                    $i++;
                }
            }
            if(ceil($countRows/$onPage)+1 == $i) break;
           $numberNavigate[] = $i;
        }
        return $numberNavigate;
    }



}