<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 29.2.2016
 * Time: 17:39
 */
class ContactController extends Controller
{

    function doIs($params)
    {
        $this->header['title'] = 'Kontakt';
        $this->head = array(
            'title' => 'Contact form',
            'keywords' => 'contact, email, form',
            'description' => 'contact form',
        );

        if(isset($_POST["email"]))
        {
            try{
            if($_POST['years'] == date("Y"))
            {
                $sendEmail = new sendEmail();
                $sendEmail->send($_POST['years'],"livefiergames@gmail.com", "Email from webs", $_POST['message'], $_POST['email']);
                $this->message('email byl odeslan');
                $this->route('Contact');
            }
            }
            catch (errorUser $error)
            {
              $this->message($error->getMessage());
            }
        }
        $this->views = 'contact';
    }
}