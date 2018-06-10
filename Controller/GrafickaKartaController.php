<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 14.7.2016
 * Time: 15:23
 */
class GrafickaKartaController extends Controller
{

    function doIs($params)
    {
        $articleManager = new ArticleManager();
        if (!empty($params[0])) {
            $graphicsCard = $articleManager->returnOneGraphicsCard('graphics_card', $params[0]);

            $this->data['name_graphics_card'] = $graphicsCard['name_graphics_card'];
            $this->data['image_graphics_card'] = $graphicsCard['image_graphics_card'];
            $this->data['games'] = $articleManager->returnGameByGraphicsCard($params[0]);
        }
        $this->views = 'graphicsCard';
    }
}