<?php

namespace controllers;

require_once 'AbstractGalleryController.php';
require_once '../constants.php';

use controllers\Controller;
use MongoDB\BSON\ObjectId;
use utils\GalleryDb;
use utils\GalleryDbImpl;
use utils\WaiDb;

class GalleryChosenController extends AbstractGalleryController
{
  private $redirectUrl = "";

  public function getRedirection(): array
  {
    return [$this->redirectUrl != "", $this->redirectUrl];
  }

  public function processRequest(array &$model)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->processPostRequest($model);
      return;
    }
    $this->processGetRequest($model);
  }

  public function getView(): string
  {
    return 'gallery_view';
  }

  private function processPostRequest(array &$model)
  {
    foreach ($_POST['checked_images'] as $image) {
      system_log("deleting image: " . $image);
      $imageIndex = array_search($image, $_SESSION['usersChosenImages']);
      unset($_SESSION['usersChosenImages'][$imageIndex]);
      $_SESSION['usersChosenImages'] = array_values($_SESSION['usersChosenImages']);
    }
    $this->redirectUrl = sprintf("gallery-chosen?page=%s", $_POST['page']);
  }

  private function processGetRequest(array &$model)
  {
    $this->setGalleryViewRelatedOptions($model);
    if (!isset($_SESSION['usersChosenImages'])) {
      $_SESSION['usersChosenImages'] = [];
    }
    $usersChosenImages = $_SESSION['usersChosenImages'];
    $usersChosenImageIds = [];
    foreach ($usersChosenImages as $image) {
      $usersChosenImageIds[] = new ObjectId($image);
    }
    $dbFilter = [
      '_id' => [
        '$in' => $usersChosenImageIds,
      ],
    ];
    $this->setImagesAndPaginationData($model, "gallery-chosen", $dbFilter);
  }

  private function setGalleryViewRelatedOptions(array &$model)
  {
    $model['active'] = 'gallery-chosen';
    $model['upload_image_form'] = false;
    $model['image_checkbox'] = "Usuń z wybranych";
    $model['memory_form_submit'] = "Usuń zaznaczone z wybranych";
    $model['action'] = $_GET['action'];
  }


}
