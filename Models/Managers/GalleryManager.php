<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 25.6.2016
 * Time: 18:59
 */
class GalleryManager
{
    /**
     * vrati galerii obrazku
     * @param $url
     * @param $table
     * @return mixed
     */
    public function returnGallery($url,$table)
    {
        return Database::allQuery("
            SELECT `url_picture`
            FROM `$table`
            WHERE  `url_game`= ?
        ", array($url));
    }

    /**
     * vrati galerii obrazku v omezenem mnozstvi
     * @param $url_game
     * @param $table
     * @param $count
     * @return mixed
     */
    public function returnGallerySetNumber($url_game,$table,$count)
    {
        return Database::allQuery("
                  SELECT `url_picture`
                  FROM `$table`
                  WHERE  `url_game`= ?
                  LIMIT $count", array($url_game)
        );
    }


}