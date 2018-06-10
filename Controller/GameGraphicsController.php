<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 11.7.2016
 * Time: 11:08
 */
class GameGraphicsController extends Controller
{

    function doIs($params)
    {
        if ($this->userLevel()) {
            $articleManager = new ArticleManager();
            $this->data['urls'] = $articleManager->returnUrlArticle('cz_text');
            $this->data['graphicsCards'] = $articleManager->returnUrlArticle('graphics_card');
            if ($_POST) {
                $data = array(
                    'url_game' => $_POST['url'],
                    'graphics_card' => $_POST['graphicsCard'],
                    'min_fps' => $_POST['min_fps'],
                    'mid_fps' => $_POST['mid_fps'],
                    'max_fps' => $_POST['max_fps'],
                    'average_fps' => $_POST['average_fps'],
                    'processor' => $_POST['processor'],
                    'ram' => $_POST['ram'],
                    'resolution_monitor' => $_POST['resolution_monitor'],
                );
                $articleManager->saveArticle(0, $data, 'gamefps');
            }

            $this->views = 'gameGraphics';
        } else
            $this->route('/');
    }
}