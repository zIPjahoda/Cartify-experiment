<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 18.4.2016
 * Time: 21:55
 */
class CommentManager
{
    /**
     * @param $table
     * @param $idArticle
     * @param $idComments
     * @param $username string; prezdivka uzivatele a nasledne odebrani veskerych html prvku kvuli bezpecnosti
     * @param $text string; text od uzivatele a nasledne odebrani veskerych html prvku kvuli bezpecnosti
     */
        public function addComment($table, $idArticle, $idComments, $username, $text)
        {
            $comment = array(
                'id_article' => $idArticle,
                'id_comments' => $idComments,
                'name' => strip_tags($username),
                'text' => strip_tags($text),
            );
            Database::insert($table,$comment);
        }

    public function idArticle($id)
    {
        return $id;
    }

    /**
     * trida ocekava ze dostane id clanku a podle toho v databazi najde nejvetsi
     * hodnotu podle idArticle
     * @param $idArticle int; id clanku
     * @return mixed
     */
    public function idComments($idArticle, $table)
    {
        return Database::oneQuery("
        SELECT `id_article`, MAX(`id_comments`)
        FROM `$table`
        WHERE `id_article` = ?
        ",array($idArticle));
    }
    //TODO Return comments
    public function returnComments($idArticle, $table)
    {
        return Database::allQuery("
            SELECT `name`, `text`
            FROM `$table`
            WHERE `id_article` = ?
            ORDER BY `id_comments` DESC
        ", array($idArticle));

    }
}