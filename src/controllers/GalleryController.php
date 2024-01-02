<?php

namespace controllers;

require_once 'AbstractGalleryController.php';
require_once '../constants.php';
require '../utils/FileSystemHelper.php';
require '../utils/GalleryDbImpl.php';
require '../utils/GdHelper.php';
require '../utils/UserInfoFetcher.php';
require '../utils/UsersDbImpl.php';

use controllers\AbstractGalleryController;
use utils\FileSystemHelper;
use utils\GalleryDb;
use utils\GalleryDbImpl;
use utils\GdHelper;
use utils\UserInfoFetcher;
use utils\UsersDbImpl;

class GalleryController extends AbstractGalleryController
{
  private $redirectUrl = "";

  public function getRedirection(): array
  {
    return [$this->redirectUrl != "", $this->redirectUrl];
  }


  public function processRequest(array &$model)
  {
    $model['userInfo'] = new UserInfoFetcher(new UsersDbImpl($this->db));
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
    switch ($_POST['form_id']) {
      case 'add_image':
        $this->handleAddNewImage($model);
        return;
      case 'memory_images':
        $this->handleMemoryImages($model);
        return;
    }
    //TODO: should handle some exception?
    $this->redirectUrl = "gallery";
  }

  private function handleMemoryImages(array &$model)
  {
    foreach ($_POST['checked_images'] as $checked_image) {
      system_log("IMAGE: " . $checked_image);
      $_SESSION['usersChosenImages'][] = $checked_image;
      $_SESSION['usersChosenImages'] = array_values(array_unique($_SESSION['usersChosenImages']));
    }
    $this->redirectUrl = sprintf("gallery?page=%s", $_POST['page']);
  }

  private function handleAddNewImage(array &$model)
  {
    $this->redirectUrl = "gallery";
    $params = ['page' => $_POST['page'] ?? 1];
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
      $thumbnailFilePath = IMAGES_DIRS['mini'] . '/' . $storedFileBaseName;
      GdHelper::copyThumbnail($storedFileName, $thumbnailFilePath);

      $this->saveImageDataInDb($storedFileBaseName);
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
  }

  private function processGetRequest(&$model)
  {
    $this->setGalleryViewRelatedOptions($model);
    $this->handleUploadResult($model);
    // TODO: handle dirPath doesn't exist
    $this->getImagesAndPaginationData($model, "gallery");
    $model['usersChosenImages'] = $_SESSION['usersChosenImages'] ?? [];
    if (isset($_SESSION['usersChosenImages'])) {
      system_log("USERS IMAGES:");
      foreach ($_SESSION['usersChosenImages'] as $key => $usersChosenImage)
        system_log($key . '->' . $usersChosenImage);
    }
  }

  private function setGalleryViewRelatedOptions(&$model)
  {
    $model['active'] = 'gallery';
    $model['upload_image_form'] = true;
    $model['image_checkbox'] = "Zapamiętaj";
    $model['memory_form_submit'] = "Zapamiętaj wybrane";
    $model['action'] = $_GET['action'];
  }

  private function handleUploadResult(&$model)
  {
    $errors = [];
    $warnings = [];
    $infos = [];
    foreach ($_GET as $key => $value) {
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

  private function saveImageDataInDb($name)
  {
    $galleryDb = new GalleryDbImpl($this->db);
    $imageData = [
      'name' => $name,
      'title' => $_POST['title'],
      'author' => $_POST['author'],
    ];
    if(isset($_POST['private']) && $_POST['private'] == 'yes'){
      $imageData['private'] = $this->userId;
    }
    $insertedId = $galleryDb->saveImageData($imageData);
    system_log("image saved in db with id: " . $insertedId);
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
