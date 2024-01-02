<?php

namespace controllers;

require_once '../constants.php';
require '../utils/GalleryDbImpl.php';
require '../utils/WaiDb.php';

use controllers\Controller;
use utils\GalleryDb;
use utils\GalleryDbImpl;
use utils\WaiDb;

class GalleryChosenController extends Controller
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
    $this->setViewRelatedOptions($model);
    $page = $_GET['page'] ?? 1;
    $this->getImagesAndPaginationData($model, $page);
  }

  private function getImagesAndPaginationData(array &$model, int $page)
  {
    $galleryDb = new GalleryDbImpl(new WaiDb());
    if (!isset($_SESSION['usersChosenImages'])) {
      $_SESSION['usersChosenImages'] = [];
    }
    $usersChosenImages = $_SESSION['usersChosenImages'];
    $imagesCount = count($usersChosenImages);
    if ($imagesCount === 0) {
      return;
    }
    $paginationData = $this->generatePaginationData($page, $imagesCount);
    $model['currentPage'] = $page;
    if ($page > $paginationData['totalPages']) {
      $page = $paginationData['totalPages'];
    }
    $model['paginationData'] = $paginationData;
    $currentDisplayed = $this->generateCurrentDisplayedData($page, $imagesCount);;
    $model['currentDisplayed'] = $currentDisplayed;
    system_log("USERS IMAGES:");
    foreach ($_SESSION['usersChosenImages'] as $key => $usersChosenImage)
      system_log($key . '->' . $usersChosenImage);

    $imagesData = [];
    for ($i = $currentDisplayed['begin'] - 1; $i < $currentDisplayed['end']; ++$i) {
      $image = $galleryDb->getImage($usersChosenImages[$i]);
      $imagesData[] = [
        'id' => $image['_id'],
        'src' => IMAGES_DIRS['mini'] . '/' . $image['name'],
        'title' => $image['title'] ?? "",
        'author' => $image['author'] ?? "",
      ];
    }
    $model['images'] = $imagesData;

  }

  private function generatePaginationData(int $currentPage, int $imagesCount): array
  {
    $pages = ceil($imagesCount / IMAGES_PER_PAGE);
    if ($currentPage > $pages) {
      $currentPage = $pages;
    }
    $navigationLinks = $this->generatePaginationLinks($currentPage, $pages, "gallery-chosen");

    return [
      'navigationLinks' => $navigationLinks,
      'totalPages' => $pages,
    ];
  }

  private function setViewRelatedOptions(array &$model)
  {
    $model['active'] = 'gallery-chosen';
    $model['upload_image_form'] = false;
    $model['image_checkbox'] = "Usuń z wybranych";
    $model['memory_form_submit'] = "Usuń zaznaczone z wybranych";
    $model['action'] = $_GET['action'];
  }


}
