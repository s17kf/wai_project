<?php

namespace controllers;

require_once '../constants.php';

use controllers\Controller;

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
    $params = [];
    $imageFieldName = 'uploaded_image';
    $imageFieldId = 'uploaded_image_id';
    system_log("");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->redirectUrl = "gallery";
      system_log("gallery by POST method ...");
      if (!empty($_FILES[$imageFieldName])) {
        system_log("image (array): " . implode(";", $_FILES[$imageFieldName]));
      }
      $uploaded_file = $_FILES[$imageFieldName];
      $file_transfer_status_code = $uploaded_file['error'];
      if ($file_transfer_status_code === UPLOAD_ERR_OK) {
        system_log("succesfully uploaded file: " . $uploaded_file['name']);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_name = $uploaded_file['tmp_name'];
        $mime_type = finfo_file($finfo, $file_name);
        system_log("real file type: " . $mime_type);
        if (!in_array($mime_type, GALLERY_ACCEPTED_FILE_TYPES)) {
          $params['file_type'] = $mime_type;
          $this->redirectUrl .= '?' . Controller::serializeParams($params);
          return;
        }
        foreach ($uploaded_file as $key => $value) {
          if ($key === 'name')
            continue;
          system_log($key . " -> " . $value);
        }
      } else {
        system_log("failed to upload file: " . $uploaded_file['name']);
        foreach ($uploaded_file as $key => $value) {
          if ($key === 'name')
            continue;
          system_log($key . " -> " . $value);
        }
        if ($file_transfer_status_code === UPLOAD_ERR_FORM_SIZE) {
          $params['file_too_big'] = 'true';
        } else {
          $params['other_error'] = $uploaded_file['error'];
        }
        $file_type = $uploaded_file['type'];
        if (!in_array($file_type, GALLERY_ACCEPTED_FILE_TYPES)) {
          $params['file_type'] = $file_type;
        }
      }
      if (!empty($params)) {
        $this->redirectUrl .= '?' . Controller::serializeParams($params);
      }
    }

    $dirPath = "images";
    $dirContent = scandir($dirPath);
    // TODO: handle dirPath doesn't exist
    $files = [];
    foreach ($dirContent as $file) {
      $filePath = $dirPath . '/' . $file;
      if (is_file($filePath)) {
        $files[] = $filePath;
        system_log("file in gallery: " . $filePath);
      }
    }
  }

  public function getView(): string
  {
    // TODO: Implement get_view() method.
    return 'gallery_view';
  }
}
