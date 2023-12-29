<?php

namespace controllers;

require_once '../constants.php';
require '../utils/FileSystemHelper.php';
require '../utils/GalleryDbImpl.php';
require '../utils/WaiDb.php';
require '../utils/GdHelper.php';

use utils\FileSystemHelper;
use utils\GalleryDb;
use utils\GalleryDbImpl;
use utils\GdHelper;
use utils\WaiDb;

class GalleryController extends Controller
{


  private $redirectUrl = "";

  public function getRedirection(): array
  {
    return [$this->redirectUrl != "", $this->redirectUrl];
  }


  public function processRequest(&$model)
  {
    // TODO: Implement fill_model() method.
    system_log("");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->processPostRequest($model);
      return;
    }
    $this->processGetRequest($model);
  }

  public function getView(): string
  {
    // TODO: Implement get_view() method.
    return 'gallery_view';
  }

  private function processPostRequest(&$model)
  {
    $this->redirectUrl = "gallery";
    $params = [];
    $imageFieldName = 'uploaded_image';
    system_log("gallery by POST method ...");
    if (!empty($_FILES[$imageFieldName])) {
      system_log("image (array): " . implode(";", $_FILES[$imageFieldName]));
    }
    $uploadedFile = $_FILES[$imageFieldName];
    $fileTransferStatusCode = $uploadedFile['error'];
    $fileExtension = pathinfo($uploadedFile['name'])['extension'];
    if ($fileTransferStatusCode === UPLOAD_ERR_OK) {
      system_log("parsing file: " . $uploadedFile['name']);
      if (!$this->isTypeAccepted($params, $uploadedFile)) {
        $this->redirectUrl .= '?' . Controller::serializeParams($params);
        return;
      }
      try {
        $storedFileName = $this->storeImageFile($uploadedFile);
      } catch (\Exception $e) {
        // TODO: proper handlin of this exception
        system_log("Exception during file storing: " . $e->getMessage());
        $params['file_save_error'] = "";
        $this->redirectUrl .= '?' . self::serializeParams($params);
        return;
      }
      $storedFileBaseName = pathinfo($storedFileName)['basename'];
      $watermarkedFilePath = IMAGES_DIRS['watermarked'] . "/" . $storedFileBaseName;
      GdHelper::copyWithWatermark($storedFileName, $watermarkedFilePath, $_POST['watermark']);
      $thumnailFilePath = IMAGES_DIRS['mini'] . '/' . $storedFileBaseName;
      GdHelper::copyThumbnail($storedFileName, $thumnailFilePath);

      $galleryDb = new GalleryDbImpl(new WaiDb());
      $imageData = [
        'name' => $storedFileBaseName,
      ];
      $insertedId = $galleryDb->saveImageData($imageData);
      system_log("image saved in db with id: " . $insertedId);
      $params['file_added'] = $uploadedFile['name'];
      system_log("succesfully uploaded file " . $uploadedFile['name'] . " watermark=" .
        $_POST['watermark']);
    } else {
      system_log("failed to upload file: " . $uploadedFile['name']);
      foreach ($uploadedFile as $key => $value) {
        if ($key === 'name')
          continue;
        system_log($key . " -> " . $value);
      }
      if ($fileTransferStatusCode === UPLOAD_ERR_FORM_SIZE) {
        $params['file_too_big'] = 'true';
      } else {
        $params['other_error'] = $uploadedFile['error'];
        // TODO: handle other_error in get parsing
      }
      if (!in_array($fileExtension, GALLERY_EXPECTED_EXTENSIONS)) {
        $params['ext'] = $fileExtension;
      }
      $file_type = $uploadedFile['type'];
      if (!empty($file_type) && !in_array($file_type, GALLERY_ACCEPTED_FILE_TYPES)) {
        $params['file_type'] = $file_type;
      }
    }
    if (!empty($params)) {
      $this->redirectUrl .= '?' . Controller::serializeParams($params);
    }
    system_log("post params:");
    foreach ($_POST as $key => $value) {
      system_log($key . " -> " . $value);
    }
  }

  private function processGetRequest(&$model)
  {
    $this->handleUploadResult($model);
    // TODO: handle dirPath doesn't exist
    $galleryDb = new GalleryDbImpl(new WaiDb());
    $page = $_GET['page'] ?? 1;
    system_log("page: " . $page);
    $paginationData = $this->generatePaginationData($galleryDb, $page);
    $model['currentPage'] = $page;
    if ($page > $paginationData['totalPages']) {
      $page = $paginationData['totalPages'];
    }
    $model['paginationData'] = $paginationData;
    $imagesCount = $galleryDb->getImagesCount();
    $model['currentDisplayed'] = [
      'begin' => ($page - 1) * IMAGES_PER_PAGE + 1,
      'end' => min(($page - 1) * IMAGES_PER_PAGE + IMAGES_PER_PAGE, $imagesCount),
      'total' => $imagesCount,
    ];
    $images = $this->getImagesOnPage($galleryDb, $page);
    $model['images'] = [];
    foreach ($images as $image) {
      $model['images'][] = [
        'id' => $image['_id'],
        'src' => IMAGES_DIRS['mini'] . '/' . $image['name'],
      ];
    }
  }

  private function getImagesOnPage(GalleryDb $galleryDb, int $page)
  {
    $skip = ($page - 1) * IMAGES_PER_PAGE;
    $limit = IMAGES_PER_PAGE;
    return $galleryDb->getImagesData(['skip' => $skip, 'limit' => $limit]);
  }

  private function generatePaginationData(GalleryDb $galleryDb, int $currentPage): array
  {
    $imagesCount = $galleryDb->getImagesCount();
    $pages = ceil($imagesCount / IMAGES_PER_PAGE);
    if ($currentPage > $pages) {
      $currentPage = $pages;
    }

    $navigation_links = [];
    if ($currentPage > 1) {
      $navigation_links[] = ['<' => 'gallery?page=' . ($currentPage - 1)];
      $navigation_links[] = [1 => 'gallery?page=' . 1];
    } else {
      $navigation_links[] = ['<' => ""];
      $navigation_links[] = [1 => ""];
    }
    if ($currentPage > 3) {
      $navigation_links[] = ['...' => ""];
    }
    if ($currentPage > 2) {
      $navigation_links[] = [$currentPage - 1 => 'gallery?page=' . ($currentPage - 1)];
    }
    if ($currentPage != 1 and $currentPage != $pages) {
      $navigation_links[] = [$currentPage => ""];
    }
    if ($currentPage < $pages - 1) {
      $navigation_links[] = [$currentPage + 1 => 'gallery?page=' . ($currentPage + 1)];
    }
    if ($currentPage < $pages - 2) {
      $navigation_links[] = ['...' => ""];
    }
    if ($currentPage < $pages) {
      $navigation_links[] = [$pages => 'gallery?page=' . $pages];
      $navigation_links[] = ['>' => 'gallery?page=' . ($currentPage + 1)];
    } else {
      $navigation_links[] = [$pages => ""];
      $navigation_links[] = ['>' => ""];
    }

    return [
      'navigationLinks' => $navigation_links,
      'totalPages' => $pages,
    ];
  }

  private function handleUploadResult(&$model)
  {
    system_log("get params:");
    $errors = [];
    $warnings = [];
    $infos = [];
    foreach ($_GET as $key => $value) {
      system_log($key . '->' . $value);
      if ($this->tryAddUploadWarning($key, $value, $warnings)) {
        continue;
      }
      if ($this->tryAddUploadError($key, $value, $errors)) {
        continue;
      }
      if ($this->tryAddUploadInfo($key, $value, $infos)) {
        continue;
      }
    }
    $model['upload_failed'] = !empty($errors) || !empty($warnings);
    $model['warnings'] = $warnings;
    $model['errors'] = $errors;
    $model['infos'] = $infos;
  }

  private function isTypeAccepted(&$params, $uploadedFile): bool
  {
    $mime_type = FileSystemHelper::getMimeType($uploadedFile['tmp_name']);
    system_log("real file type: " . $mime_type);
    if (!in_array($mime_type, GALLERY_ACCEPTED_FILE_TYPES)) {
      $params['file_type'] = $mime_type;
      return false;
    }
    return true;
  }

  private function storeImageFile($uploadedFile)
  {
    $fileNameStripped = pathinfo($uploadedFile['name'])['filename'];
    $mime_type = FileSystemHelper::getMimeType($uploadedFile['tmp_name']);
    $destFilepath = FileSystemHelper::getNextAvailableName(
      IMAGES_DIRS['full'], $fileNameStripped, GALLERY_FILETYPE_TO_EXTENSION[$mime_type]);
    if (!move_uploaded_file($uploadedFile['tmp_name'], $destFilepath)) {
      throw new \Exception("Failed to move file");
    }
    return $destFilepath;
  }

  private function tryAddUploadWarning($key, $arg, &$warnings): bool
  {
    switch ($key) {
      case "ext":
        $warnings[] = "Przesłany plik z rozrzerzeniem ." . $arg . ". Oczekiwane rozszerzenia: " .
          implode(", ", GALLERY_EXPECTED_EXTENSIONS);
        return true;
    }
    return false;
  }

  private function tryAddUploadError($key, $arg, &$errors): bool
  {
    switch ($key) {
      case "file_too_big":
        $maxSize = GALLERY_IMAGE_MAX_SIZE / (1000000);
        $errors[] = "Przesłany plik jest za duży. Maksymalny dopuszczalny rozmiar to " . $maxSize . "MB";
        return true;
      case "file_type":
        $errors[] = "Akceptowane typy plików: " . implode(", ", GALLERY_ACCEPTED_FILE_TYPES) .
          ". Przesłany plik jest typu " . $arg;
        return true;
      case "file_save_error":
        $errors[] = "Nie udało się dodać pliku do galerii";
        return true;
    }
    return false;
  }

  private function tryAddUploadInfo($key, $arg, &$infos): bool
  {
    switch ($key) {
      case "file_added":
        $infos[] = "Plik " . $arg . " dodany do galerii";
        return true;
    }
    return false;
  }
}
