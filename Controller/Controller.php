<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 25.2.2016
 * Time: 19:19
 */
abstract class Controller
{
    //pole pro napln vsech promennych
    protected $data = array();
    protected $views = '';
    protected $header = array("title" => "", "description" => "","image" => "","type" => "","url" => "");
    
    abstract function doIs($params);

    /**
     *  _ neosetrena promena
     * Zjisti pohled(views) a vlozi ho do Controlleru
     * A extractuje vsechny promenne
     */
    public function getViews(){

        if($this->safe($this->views)){
            //extract vlozi obsah z promenne do pohledu
            extract($this->data);
            extract($this->data, EXTR_PREFIX_ALL, "");
            require "Views/" . $this->views . ".phtml";
        }
    }

    /**
     * presmerovani na jinou stranku
     * Location/ napr csgo.eu/... a akorat pridame chyba
     * @param $url String; Na jakour url adresu presmerovat
     */
    public function route($url){
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

    /**
     * @param null $x
     * @return array|null|string
     */
    private function safe($x = null)
    {
        if (!isset($x))
            return null;
        elseif (is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x))
        {
            foreach($x as $k => $v)
            {
                $x[$k] = $this->osetri($v);
            }
            return $x;
        }
        else
            return $x;
    }

    public function addMessage($message)
    {
     if(isset($_SESSION['message']))
         $_SESSION['message'][] = $message;
        else
            $_SESSION['message'] = array($message);
    }

    public static function returnMessage()
    {
        if(isset($_SESSION['message'])){
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
            return $message;
        }
        else
            return array();
    }

    /**
     * zjisti zda je uzivatel prihlaseny  apote
     * @param bool $admin
     */
    public function  userAuthentication($admin = false)
    {
        $userManager = new UserManager();
        $user = $userManager->returnUser();
        if(!$user || ($admin && $user['levelAdmin']))
        {
            $this->addMessage('error opravneni');
            $this->route('login');
        }
    }


    /**
     * vrati level uzivatele
     * @return mixed
     */
    public function userLevel()
    {
        $userManager = new UserManager();
        $user = $userManager->returnUser();
        if(!$user) return 0;
        return $user['levelAdmin'];
    }

    public function setSearchParse($text)
    {
            $_SESSION['text'] = $text;
    }
    
    public function returnSearchParse()
    {
        return $_SESSION['text'];
    }
}