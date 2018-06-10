<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 25.2.2016
 * Time: 19:53
 */
class RouterController extends Controller
{

    protected $controller;

    function doIs($params)
    {
        $parseUrl = $this->parseURL($params[0]);

        if ($parseUrl[0] == 'googlef0fb0b57927050b9.html')
            $this->route('googlef0fb0b57927050b9');

        //kdyz je prazda pr. hwnaroky.cz tot vse tak vlozi specialni Controller jinak vlozi to co je v url
        if (empty($parseUrl[0]))
            $classController = 'IndexController';
        else
            $classController = $this->editAllURLAddresses(array_shift($parseUrl)) . "Controller";

        if (file_exists('Controller/' . $classController . '.php'))
            $this->controller = new $classController;
        else
            $this->route('error');

        //zavole Controller a vybere z nej data doIs
        $this->controller->doIs($parseUrl);

        $this->data["title"] = $this->controller->header["title"];
        $this->data["description"] = $this->controller->header["description"];
        $this->data["image"] = $this->controller->header["image"];
        $this->data["url"] = $this->controller->header["url"];

        $this->data['messages'] = $this->returnMessage();

        

        $userManager = new UserManager();


        $this->data['user'] = $userManager->returnUser();
        $this->views = 'main';

    }

    /**
     * upravi adresu tak abychom zjiskali nazev Controlleru
     * @param $texts
     * @return mixed|string
     */
    private function editAllURLAddresses($texts)
    {
        $sentence = str_replace('-', ' ', $texts);
        $sentence = ucwords($sentence);
        $sentence = str_replace(' ', '', $sentence);
        return $sentence;
    }

    /**
     * rozdeli url adresu na pole(array)
     * @param $url string;
     * @return array
     */
    private function parseURL($url)
    {
        $adress = parse_url($url);
        $adress["path"] = ltrim($adress["path"], "/");
        $adress["path"] = trim($adress["path"]);
        $explodeAdress = explode("/", $adress["path"]);
        return $explodeAdress;
    }


}