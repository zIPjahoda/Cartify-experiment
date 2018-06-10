<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 17.4.2016
 * Time: 10:36
 */
class BoardController extends  Controller
{

    function doIs($params)
    {
        // do Board maji pristup jen prihlaseni uzivatele
        $this->userAuthentication();

        $this->header['title'] = 'login';

        $userManager = new UserManager();
        if(!empty($params[0])&& $params[0] == 'logout')
        {
            $userManager->logout();
            $this->route('login');
        }
        $user = $userManager->returnUser();
        $this->data['username'] = $user['username'];
        $this->data['levelAdmin'] = $user['levelAdmin'];

        $this->views = 'board';
    }
}