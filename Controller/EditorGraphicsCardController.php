<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 13.7.2016
 * Time: 13:17
 */
class EditorGraphicsCardController extends Controller
{

    function doIs($params)
    {
        if ($this->userLevel()) {
            $articleManager = new ArticleManager();
            if ($_POST) {
                $data = array(
                    'url' => $_POST['url'],
                    'name_graphics_card' => $_POST['name_graphics_card'],
                    'image_graphics_card' => $_POST['image_graphics_card'],
                );
                $articleManager->saveArticle(0, $data, 'graphics_card');
                $this->addMessage('uspesne ulozeni clanku');
                $this->route('home');
            }
            $this->views = 'editorGraphics';
        
        } else
            $this->route('/');
    }
}