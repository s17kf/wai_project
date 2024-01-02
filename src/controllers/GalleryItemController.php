<?php

namespace controllers;

require_once '../constants.php';
require '../utils/GalleryDbImpl.php';

use utils\GalleryDbImpl;
use utils\WaiDb;

class GalleryItemController extends Controller
{

  public function processRequest(array &$model)
  {
    $id = $_GET['img'];
    $galleryDb = new GalleryDbImpl(new WaiDb());
    $image = $galleryDb->getImage($id);
    $model['image_src'] = IMAGES_DIRS['watermarked'] . '/' . $image['name'];
    $model['page'] = $_GET['page'];
    $model['return_url'] = $_GET['return'];
  }

  public function getView(): string
  {
    return 'gallery_item_view';
  }
}
