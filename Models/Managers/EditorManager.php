<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 13.3.2016
 * Time: 0:07
 */
class EditorManager
{
    /**
     * Vypise vsechny sloupce z tabulky;
     * @param $table string;
     * @return array
     */
    private $countColumn;
    public function fieldName($table)
    {
        $list = array();
        //pocet sloupcu
       $this->countColumn = Database::columnCout("SELECT * FROM `$table`");
        for ($i = 0; $i < $this->countColumn; $i++) {
            //vypis sloupce po 1
            $list[] = Database::getColumnMeta("SELECT * FROM `$table`",$i);
        }
        return $list;
    }


    /**
     * Ulozi clanek do databaze a nebo poznmeni clanek pdole id
     * @param $id int; cislo id clank
     * @param $article string; co bude ukladat
     * @param $table string; nazev tabulky
     */
    public function saveArticle($id, $article, $table)
    {
        if(!$id)
            Database::insert($table, $article);
        else
            // TODO Dodelat zmenu clanku Where
            Database::change($table, $article, 'WHERE id = ?', array($id));
    }

    /**
     * pocet sloupcu v databazi
     * @param $table
     * @return mixed
     */
    public function countLine($table)
    {
        return Database::columnCout("SELECT * FROM `$table`");
    }

}