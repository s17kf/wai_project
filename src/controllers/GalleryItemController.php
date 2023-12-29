<?php

namespace controllers;

require_once '../constants.php';
require '../utils/GalleryDbImpl.php';
require '../utils/WaiDb.php';

use utils\GalleryDbImpl;
use utils\WaiDb;

class GalleryItemController extends Controller
{

  public function processRequest(&$model)
  {
    $id = $_GET['img'];
    $galleryDb = new GalleryDbImpl(new WaiDb());
    $image = $galleryDb->getImage($id);
    $model['image_src'] = IMAGES_DIRS['watermarked'] . '/' . $image['name'];
    $model['page'] = $_GET['page'];
    // TODO: Implement processRequest() method.
  }

  public function getView(): string
  {
    // TODO: Implement getView() method.
    return 'gallery_item_view';
  }
}
