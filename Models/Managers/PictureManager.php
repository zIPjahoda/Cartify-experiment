<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 27.4.2016
 * Time: 20:39
 */
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Filter\Basic;
use Imagine\Gd;

class PictureManager
{
    /**
     * vrati sirku obrazku
     * @param $image
     * @return int
     */
    public function widthPicture($image)
    {
        return imagesx($image);
    }

    /**
     * vrati vysku obrazku
     * @param $image
     * @return int
     */
    public function heightPicture($image)
    {
        return imagesy($image);
    }

    /**
     * Tato trida vytvori obrazek v nastavenem rozlisenim  a jestlize se obrazek
     * nevejde do pomeru stran aby nebyl zbytecne roztahly, tak ho orizne a  vznikne presne stejna velikost a stejny pomer stran
     * @param $image ; aktualni obrazek
     * @param $savePicture string; nazev obrazku
     * @param $newWidthPicture int; nova Vyska obrazku
     * @param $newHeightPicture int; nova Sirka obrazku
     * @return bool
     */
    public function setNewResolutionPictureAndCreatePicture($image, $savePicture, $newWidthPicture, $newHeightPicture)
    {


        $widthPicture = $this->widthPicture($image);
        $heightPicture = $this->heightPicture($image);

        $originalAspect = $widthPicture / $heightPicture;
        $newOriginalAspect = $newWidthPicture / $newHeightPicture;

        if ($originalAspect >= $newOriginalAspect) {
            $new_height = $newHeightPicture;
            $new_width = $widthPicture / ($heightPicture / $newHeightPicture);
        } else {
            $new_height = $heightPicture / ($widthPicture / $newWidthPicture);
            $new_width = $newHeightPicture;
        }

        $newResolution = imagecreatetruecolor($newWidthPicture, $newHeightPicture);

        imagecopyresampled($newResolution, $image, 0 - ($new_width - $newWidthPicture) / 2, 0 - ($new_height - $newHeightPicture) / 2, 0, 0, $new_width, $new_height, $widthPicture, $heightPicture);


        imagepng($newResolution, $savePicture, NULL);


    }

    public function setNewResolutionPictureAndCreatePictureWithoutCrop($image, $savePicture, $newWidthPicture, $newHeightPicture)
    {


        $widthPicture = $this->widthPicture($image);
        $heightPicture = $this->heightPicture($image);

        $originalAspect = $widthPicture / $heightPicture;
        $newOriginalAspect = $newWidthPicture / $newHeightPicture;

        if ($originalAspect >= $newOriginalAspect) {
            $new_height = $newHeightPicture;
            $new_width = $widthPicture / ($heightPicture / $newHeightPicture);
        } else {
            $new_height = $heightPicture / ($widthPicture / $newWidthPicture);
            $new_width = $newHeightPicture;
        }

        $newResolution = imagecreatetruecolor($newWidthPicture, $newHeightPicture);

        imagecopyresampled($newResolution, $image, 0, 0, 0, 0, $new_width, $new_height, $widthPicture, $heightPicture);


        imagepng($newResolution, $savePicture, NULL);


    }


    public function imageTypeFile($imageSource, $target_file)
    {
        $type = pathinfo($imageSource, PATHINFO_EXTENSION);
        if ($type == 'png' || $type == 'PNG')
            return imagecreatefrompng($target_file);
        elseif ($type == 'jpg' || $type = 'jpeg')
            return imagecreatefromjpeg($target_file);
        elseif ($type == 'gif')
            return imagecreatefromgif($target_file);
    }
}