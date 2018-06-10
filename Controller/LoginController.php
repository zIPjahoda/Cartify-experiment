<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 17.4.2016
 * Time: 18:01
 */
class LoginController extends Controller
{

    function doIs($params)
    {
        $userManager = new UserManager();
        if($userManager->returnUser())
            $this->route('board');

        $this->header['title'] = 'Login';

        if($_POST)
    {
        try
        {
            $userManager->login($_POST['username'], $_POST['password']);
            $this->addMessage('sucess login');
            $this->route('board');
        }
        catch(errorUser $error)
        {
            $this->addMessage($error->getMessage());
        }
    }
        $this->views = 'login';
    }
}