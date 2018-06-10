<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 29.2.2016
 * Time: 17:22
 */
class ErrorController extends Controller
{

    function doIs($params)
    {
        header("HTTP/1.0 404 Not Found");
        $this->header["title"] = 'Error 404';
        $this->views = 'error';
    }
}