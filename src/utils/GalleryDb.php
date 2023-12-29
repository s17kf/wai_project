<?php

namespace utils;

interface GalleryDb
{
  public function saveImageData($imageData);

  public function getImagesData($options = []);

  public function getImage($id);

  public function getImagesCount();
}
