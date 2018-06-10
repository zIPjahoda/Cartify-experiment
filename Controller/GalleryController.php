<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 25.6.2016
 * Time: 18:56
 */
class GalleryController extends Controller
{
    
    function doIs($params)
    {
        $galleryManager = new GalleryManager();
        if(!empty($params[0]))
        {
            $this->header['title'] = 'Hw nároky her';
            $this->header['description'] = 'Hardwarové nároky všech her, veškerá datábaze her';
            
            $this->data['gallery'] = $galleryManager->returnGallery($params[0],'gallery');
            
            $this->views = 'gallery';
        }
        else
        {
            $this->header['title'] = 'Hw nároky her';
            $this->header['description'] = 'Hardwarové nároky všech her, veškerá datábaze her';
            
            
            $this->views = 'homeGallery';
        }
    }

}