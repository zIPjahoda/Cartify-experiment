<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 30.6.2016
 * Time: 16:27
 */
class RatingController extends Controller
{

    function doIs($params)
    {
        $table = 'ratearticle';
        $cookie_key = $params[0];
        $cookie_value = 1;

        if (!isset($_COOKIE[$cookie_key])) {
            $staredManager = new StaredManager();
            if (isset($_POST['rate']) && !empty($_POST['rate'])) {
                $staredData = $staredManager->returnData($table, $params[0]);

                $countStared = $staredData['count_star'];
                $allValueArticle = $staredData['value_Star'];

                $newCountStare = $countStared + 1;
                $newAllValueArticle = $allValueArticle + $_POST["rate"];

                $updateDataStared = array(
                    'count_star' => $newCountStare,
                    'value_Star' => $newAllValueArticle,
                );

                $staredManager->updateDataAndRefresh($table, $updateDataStared, 'WHERE `urlArticle` = ?', array($params[0]));
            }

            setcookie($cookie_key, $cookie_value, time() + (86400 * 30), "/");
        }
    }
}