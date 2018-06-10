<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 29.2.2016
 * Time: 21:01
 */
class ArticleManager
{
    public function returnUrlArticle($table)
    {
        return Database::allQuery('
        SELECT *
        FROM '.$table.'
        ORDER BY `id` DESC
        ');
    }

    /**
     * vrati seznam
     * @param $table
     * @param $url
     * @return mixed
     */
    public function returnGraphicsCard($table, $url)
    {
        return Database::allQuery('
        SELECT *
        FROM `gamefps`
        INNER JOIN `graphics_card`
        ON `gamefps`.`graphics_card` = `graphics_card`.`url`
        WHERE  `gamefps`.`url_game`=?
        ', array($url));

    }

    /**
     * vrati seznam
     * @param $table
     * @param $url
     * @return mixed
     */
    public function returnAllGamesByGraphicsCard($table, $url)
    {
        return Database::allQuery('
        SELECT *
        FROM `gamefps`
        INNER JOIN `graphics_card`
        ON `gamefps`.`graphics_card` = `graphics_card`.`url`
        WHERE  `gamefps`.`url_game`=?
        ', array($url));

    }
    /**
     * vrati seznam
     * @param $table
     * @param $url
     * @return mixed
     */
    public function returnOneGraphicsCard($table, $url)
    {
        return Database::oneQuery('
        SELECT *
        FROM `graphics_card`
        WHERE `url` = ?
        ', array($url));

    }

    /**
     * vrati seznam
     * @param $urlGame
     * @return mixed
     */
    public function returnGameByGraphicsCard($urlGame)
    {
        return Database::allQuery('
        SELECT *
        FROM `gamefps`
        WHERE `url_game` = ?
        ', array($urlGame));

    }
    /**
     * vrati clanek podle url a spoji 2 tabulky do jedne podle id
     * @param $url
     * @param $table
     * @param $table2
     * @return mixed
     */
    public function returnArticle($url, $table, $table2)
    {
        return Database::oneQuery("
            SELECT *
            FROM `$table2`
            INNER JOIN `$table`
            ON `$table`.`id` = `$table2`.`id`
            WHERE  `$table2`.`url`=?
        ", array($url));
    }

    /**
     * vrati vsechny clanky z databaze
     * @param $table string; Nazev tabulky z jake to ma brat
     * @return mixed
     */
    public function returnArticles($table)
    {
        return Database::allQuery('
            SELECT `id`, `title`, `url`, `description` , `contents`, `date`, `keywords`, `date`, `image`, `type`
            FROM '.$table.'
            ORDER BY `id` DESC
        ');
    }

    public function getRows()
    {
        return Database::oneQuery('
        SELECT COUNT(id)
        as rows FROM `article`
        ');
    }

    /**
     * vrati pocet clanku z databaze
     * @param $limit int; kolik potrebujete clanku
     * @param $onPage int;
     * @return mixed
     */
    public function numberArticles($limit,$onPage){
        return Database::allQuery("
            SELECT `id`, `title`, `url`, `description`
            FROM `article`
            LIMITS `$limit`, `$onPage`
        ");
    }


    /**
     * @param $id
     * @param $article
     */
    public function saveArticle($id, $article, $table)
    {
            Database::insert($table, $article);
    }

    /**
     * ulozi nekolik obrazku
     * 
     */
    public function saveMultiple($table, $params)
    {
        Database::multipleInsert($table, $params);
    }
/*

    /**
     * @param $url
     */
    public function deleteArticle($url)
    {
        Database::query('
            DELETE FROM tutorials
            WHERE url = ?
        ', array($url));
    }


}