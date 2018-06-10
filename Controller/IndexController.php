<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 16.4.2016
 * Time: 19:31
 */
class IndexController extends Controller
{
    function doIs($params)
    {
        $tutorialsManager = new TutorialsManager();
        $listManager = new ListManager();
        $userManager = new UserManager();
        $this->header['title'] = 'Hw nároky všech her';
$this->header['description'] = 'Hardwarové nároky všech her, veškerá datábaze her';
        $table = 'allspec';
        $table2 = 'cz_text';
        $onPage = 2;

        $this->data['articles'] = $tutorialsManager->countLimit('allspec', 25,'cz_text');
        $this->data['xxxx'] = $listManager->returnArticleInLimit($table,1,$onPage, $table2);
        $this->data['numbers'] = $listManager->setNumberList($table,1,$onPage);
        $this->data['levelAdmin'] = $userManager->returnUser();
        $this->views = 'index';
    }
}		