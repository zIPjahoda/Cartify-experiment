<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 11.4.2016
 * Time: 19:01
 */
class HwpozadavkyController extends Controller
{

    function doIs($params)
    {
        $articleManager = new ArticleManager();
        $listManager =  new ListManager();
        $userManager = new UserManager();
        $commentManager = new CommentManager();
        $galleryManager = new GalleryManager();
        $staredManager = new StaredManager();

        $table = 'allspec';
        $table2 = 'cz_text';
        $commentTable = 'cz_comments_game_spec';
        $onPage = 25;
        $this->header['title'] = 'Hw nároky her';
        $this->header['description'] = 'Hardwarové nároky všech her, veškerá datábaze her';
        $user = $userManager->returnUser();
        $this->data['levelAdmin'] = $user && $user['levelAdmin'];

        if(!empty($params[1]) && $params[1] == 'delete')
        {
            if($this->userLevel() != 4){
                $this->route('board');
                $this->addMessage('your not admin');
            }
            $articleManager->deleteArticle($params[0]);
            $this->addMessage('articel has been delete sucess');
            $this->route('/');
        }

        //strankovani vysledku
        else if(!empty($params[0]) && $params[0] == 'stranka') {
            if (ctype_digit($params[1])) {
                $this->data['articles'] = $listManager->returnArticleInLimit($table,$params[1],$onPage, $table2);
                $this->data['numbers'] = $listManager->setNumberList($table,$params[1],$onPage);
                $this->header['description'] = 'strana '.$params[1].' Hardwarové nároky všech her, veškerá datábaze her, datum vydání';
                $this->header['title'] = 'strana '.$params[1].' Hw nároky her';
                $this->views = 'index';
            }
            else{
                $this->addMessage('eror');
                $this->route('error');
            }

        }
        //vypis clanku podle url
        else if (!empty($params[0])) {
            $article = $articleManager->returnArticle($params[0], $table, $table2);
            $idcomments = $commentManager->idComments($article['id'], $commentTable);


            $id = $idcomments['MAX(`id_comments`)'];
            $id += 1;
            $idArticle = $article['id'];
            if (!$article) $this->route('error');
            if($_POST) $commentManager->addComment($commentTable,$idArticle,$id,$_POST['name'],$_POST['comment']);

            $this->header = array(
                'title' => $article['title'],
                'description' => $article['description'],
                'image' => '/Photos/NoCompile/'.$article['image'],
                'url' => $article['url'],
            );

            $this->data['date'] = $article['date'];
            $this->data['title'] = $article['title'];
            $this->data['image'] = $article['image'];
            $this->data['imageAlt'] = $article['imageAlt'];
            $this->data['imageTitle'] = $article['imageTitle'];
            $this->data['contents'] = $article['contents'];
            $this->data['minProcessorIntel'] = $article['minProcessorIntel'];
            $this->data['maxProcessorIntel'] = $article['maxProcessorIntel'];
            $this->data['minProcessorAMD'] = $article['minProcessorAMD'];
            $this->data['maxProcessorAMD'] = $article['maxProcessorAMD'];
            $this->data['minRAM'] = $article['minRAM'];
            $this->data['maxRAM'] = $article['maxRAM'];
            $this->data['operatingSystem'] = $article['operatingSystem'];
            $this->data['renderDirectX'] = $article['renderDirectX'];
            $this->data['HDD'] = $article['HDD'];
            $this->data['minGraphicsInvidia'] = $article['minGraphicsInvidia'];
            $this->data['maxGraphicsInvidia'] = $article['maxGraphicsInvidia'];
            $this->data['minGraphicsAMD'] = $article['minGraphicsAMD'];
            $this->data['maxGraphicsAMD'] = $article['maxGraphicsAMD'];
            $this->data['url'] = $article['url'];
            $this->data['stared'] = $staredManager->percentSum('ratearticle',$article['url']);
            $this->data['gamesfps'] = $articleManager->returnGraphicsCard('neni treba',$params[0]);
            $this->data['comments'] = $commentManager->returnComments($article['id'],$commentTable);
            $this->data['levelAdmin'] = $this->userLevel();


            $this->data['gallery'] = $galleryManager->returnGallerySetNumber($params[0],'gallery',6);

            $this->views = 'article';

        }
        //uvod
        else {
            $this->data['articles'] = $listManager->returnArticleInLimit($table,1,$onPage, $table2);
            $this->data['numbers'] = $listManager->setNumberList($table,1,$onPage);

            $this->views = 'index';
        }
    }
}	