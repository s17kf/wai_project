<?php

namespace utils;

interface GalleryDb
{
  public function saveImageData($imageData);

  public function getImagesData($options = [], string $loggedUserId = null, array $userFilter = null);

  public function getImage($id);

  public function getImagesCount(string $loggedUserId = null, array $userFilter = null);
}
