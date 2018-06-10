<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 29.2.2016
 * Time: 20:22
 */
class Database
{
    private static $connect;

    private static $settings = array(
        PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,);

    /**
     * @param $host string; server FTP
     * @param $username string; Jmeno
     * @param $password string; heslo
     * @param $database string; databaze
     */
    public static function connect($host, $username, $password, $database){
        if(!isset(self::$connect)){
            self::$connect = @new PDO("mysql:host=$host;dbname=$database",
                $username,
                $password,
                self::$settings
        );
        }
    }

    /**
     * vraceni clanku, uzivatele
     * @param $query; text se zastupnymi znaky
     * @param array $params
     * @return mixed
     */
    public static function oneQuery($query, $params = array())
    {
        $return = self::$connect->prepare($query);
        //pripoji pole parametru
        $return->execute($params);
        return $return->fetch();
    }


    /**
     * vrati pocet sloupcu v databazi
     * @param $query; text se zastupnymi znaky
     * @param array $params
     * @return mixed
     */
    public static function columnCount($query, $params = array())
    {
        $return = self::$connect->prepare($query);
        //pripoji pole parametru
        $return->execute($params);
        return $return->columnCount();
    }

    public static function query($query, $params = array()) {
        $return = self::$connect->prepare($query);
        $return->execute($params);
        return $return->rowCount();
    }

    /**
     * Vrati pocet radku v databazi vhodne na strankovani
     * @param $query string;
     * @param array $params string;
     * @return mixed int; vrati cislo/pocet radku
     */
    public static function countRows($query, $params = array())
    {
        $return = self::$connect->prepare($query);
        $return->execute($params);
        return $return->rowCount();
    }
    /**
     * Vypise nazev sloupce cisla podle indexu
     * @param $query string; dotaz co
     * @param $number int; cislo jaky sloupec chcete vypsat
     * @param $params
     * @return mixed
     */
    public static function getColumnMeta($query, $number ,$params = array())
    {
        $return = self::$connect->prepare($query);
        //pripoji pole parametru
        $return->execute($params);
        return $return->getColumnMeta($number);

    }

    /**
 * @param $limit int; kolik vypsat vysledku
 * @param $onPage int; odkud zacit(z radku)
 * @return mixed
 */
    public  function limitedLineFetch($limit, $onPage)
    {
        $stmt = self::$connect->prepare("SELECT `id`, `title`, `url`, `description` FROM `article` LIMIT :limit, :perpage");
        $stmt->bindParam(':perpage', $onPage, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * pouziti na strankovani
     * @param $query string;
     * @param array $params
     * @param $limit int; limit od kud ma zacit
     * @param $onPage int; a kolik vypise vysledku na stranku
     */
    public static function queryCountLine($query, $limit, $onPage, $params = array())
    {
        $return = self::$connect->prepare($query);
        $return->bindParam(':perpage', $onPage, PDO::PARAM_INT);
        $return->bindParam(':limit', $limit, PDO::PARAM_INT);
        $return->execute();
        return $return->fetchAll();
    }

    /**
     * dotaz pro vypis galerie obrazku
     * @param $query
     * @param $limit
     * @return mixed
     */
    public static function queryCountGallery($query)
    {
        $return = self::$connect->prepare($query);

        $return->execute();
        return $return->fetchAll();
    }

    /**
     * napriklad pro vypis clanku, komentare
     * @param $query
     * @param array $params
     */
    public static function allQuery($query, $params = array())
    {
        $return = self::$connect->prepare($query);
        $return->execute($params);
        return $return->fetchAll();
    }

    /**
     * vrati prvni hodnotu v sloupci
     * @param $query
     * @param array $params
     * @return mixed
     */
    public static function queryColumn($query, $params = array())
    {
        $result = self::oneQuery($query, $params);
        return $result[0];
    }



    /**
     * vrati pocet ovlivnenych radku
     * @param $query
     * @param array $params
     * @return mixed
     */
    public static function queryCount($query, $params = array())
    {
        $return = self::$connect->prepare($query);
        $return->execute($params);
        return $return->rowCount();
    }

    /**
     * vlozi to tabulky ruzne hodnoty, ktere prijdou v poli $params
     *  a tyto hodnoty rozdeli Inser, VALUE  a postne
     * @param $table
     * @param array $params
     * @return mixed
     */
    public static function insert($table , $params = array()){
        return self::oneQuery("INSERT INTO `$table` (`".
            implode('`, `', array_keys($params)).
            "`) VALUES (".str_repeat('?,', sizeOf($params)-1)."?)",
            array_values($params));
    }

    /**
     * zmeni v clanku data ktera byla zmenena
     * @param $table
     * @param array $values
     * @param $if
     * @param array $params
     * @return mixed
     */
    public static function change($table, $values =  array(), $if, $params = array()){
        return self::query("UPDATE `$table` SET `".
            implode('` = ?, `', array_keys($values)).
            "` = ? " . $if,
            array_merge(array_values($values), $params));
    }

    public static function getLastID()
    {
        return self::$connect->lastInsertId();
    }

}		