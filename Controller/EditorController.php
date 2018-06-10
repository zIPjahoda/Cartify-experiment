<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 6.3.2016
 * Time: 9:00
 */
class EditorController extends Controller
{
    
    function doIs($params)
    {
        $articleManager = new ArticleManager();
        $pictureManager = new PictureManager();

        if ($this->userLevel()) {
            if ($_POST) {

                //cilova slozka na upload
                $target_file = "Photos/NoCompile/" . basename($_FILES["image"]["name"]);


                if (basename($_FILES["image"]["name"])) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                        $pictureManager->setNewResolutionPictureAndCreatePictureWithoutCrop($pictureManager->imageTypeFile($imageFileType, $target_file), "Photos/GameSpec/" . basename($_FILES["image"]["name"]), 240, 325);
                    }
                }
/*
                if (isset($_FILES['gallery'])) {
                    $gallery = $_FILES['gallery'];
                    $fileCount = count($gallery["name"]);
                    for ($i = 0; $i < $fileCount; $i++) {
                        $galleryTargetSave = "Photos/Gallery/" . basename($_FILES["gallery"]["name"][$i]);
                        move_uploaded_file($_FILES["gallery"]["tmp_name"][$i], $galleryTargetSave);

                        $imageTypeUploadFile = pathinfo($galleryTargetSave, PATHINFO_EXTENSION);
                        $galleryTargetSaveMini = "Photos/Gallery/" . basename($_FILES["gallery"]["name"][$i]);
                        $pictureManager->setNewResolutionPictureAndCreatePictureWithoutCrop($pictureManager->imageTypeFile($imageTypeUploadFile, $galleryTargetSaveMini),"Photos/GalleryMini/" . basename($_FILES["gallery"]["name"][$i]),240,220);
                        $articleManager->saveArticle($_POST['id'],
                            array(
                        'url_game' => $_POST["url"],
                        'url_picture' => basename($_FILES["gallery"]["name"][$i]),
                        ), 'gallery');
                    }

                }
*/
                $allUpload = array(
                    'image' => basename($_FILES["image"]["name"]),
                    'minProcessorIntel' => $_POST["minProcessorIntel"],
                    'maxProcessorIntel' => $_POST["maxProcessorIntel"],
                    'minProcessorAMD' => $_POST["minProcessorAMD"],
                    'maxProcessorAMD' => $_POST["maxProcessorAMD"],
                    'minGraphicsInvidia' => $_POST["minGraphicsInvidia"],
                    'maxGraphicsInvidia' => $_POST["maxGraphicsInvidia"],
                    'minGraphicsAMD' => $_POST["minGraphicsAMD"],
                    'maxGraphicsAMD' => $_POST["maxGraphicsAMD"],
                    'minRAM' => $_POST["minRAM"],
                    'maxRAM' => $_POST["maxRAM"],
                    'operatingSystem' => $_POST["operatingSystem"],
                    'renderDirectX' => $_POST["renderDirectX"],
                    'HDD' => $_POST["HDD"],
                    'nameGame' => $_POST["nameGame"],
                );

                $czArticle = array(
                    'title' => $_POST["title"],
                    'contents' => $_POST["contents"],
                    'url' => $_POST["url"],
                    'description' => $_POST["description"],
                    'imageTitle' => $_POST["imageTitle"],
                    'imageAlt' => $_POST["imageAlt"],
                    'videos' => $_POST["videos"],
                );
                $createLineStaredArticle = array(
                    'value_Star' => 0,
                    'urlArticle' =>$_POST["url"],
                    'count_star' => 0,
                );
                $articleManager->saveArticle($_POST['id'], $allUpload, 'allspec');
                $articleManager->saveArticle($_POST['id'], $czArticle, 'cz_text');
                $articleManager->saveArticle($_POST[''],$createLineStaredArticle,'ratearticle');

                $this->addMessage('článek byl uložen');
                $this->route('hwpozadavky/' . $czArticle['url']);
            } else if (!empty($params[0])) {
                $articleLoad = $articleManager->returnArticle($params[0], 'allspec', 'cz_text');
                if ($articleLoad)
                    $article = $articleLoad;
                else
                    $this->message('clanek neexistuje');
            }
            $this->views = 'editor';
        } else
            $this->route('/');
    }
}				