<?php

namespace utils;

class GdHelper
{
  public static function copyWithWatermark($inputFilePath, $outputFilePath, $watermark)
  {
    $mimeType = FileSystemHelper::getMimeType($inputFilePath);
    $imageCreateFunction = self::getImageCreateFunction($mimeType);
    $imageStoreFunction = self::getImageStoreFunction($mimeType);

    $img = $imageCreateFunction($inputFilePath);
    $black = imagecolorallocate($img, 0x00, 0x00, 0x00);
    $font = './Inconsolata.ttf';
    $watermarkXPosition = imagesx($img) / 10;
    $watermarkYPosition = imagesy($img) - imagesy($img) / 10;

    imagefttext($img, imagesy($img) / 10, 45, $watermarkXPosition, $watermarkYPosition,
      $black, $font, $watermark);
    $imageStoreFunction($img, $outputFilePath);
  }

  public static function copyThumbnail($inputFilePath, $outputFilePath, $new_width = 200, $new_height = 125)
  {
    $mimeType = FileSystemHelper::getMimeType($inputFilePath);
    $imageCreateFunction = self::getImageCreateFunction($mimeType);
    $imageStoreFunction = self::getImageStoreFunction($mimeType);;

    $img = $imageCreateFunction($inputFilePath);
    $thumb = imagecreatetruecolor($new_width, $new_height);
    imagecopyresized($thumb, $img, 0, 0, 0, 0, $new_width, $new_height, imagesx($img), imagesy($img));

    $imageStoreFunction($thumb, $outputFilePath);
  }

  private static function getImageCreateFunction($mimeType)
  {
    switch ($mimeType) {
      case 'image/jpeg':
        return 'imagecreatefromjpeg';
      case 'image/png':
        return 'imagecreatefrompng';
    }
    throw new \UnexpectedValueException("unexpected file type " . $mimeType);
  }

  private static function getImageStoreFunction($mimeType)
  {
    switch ($mimeType) {
      case 'image/jpeg':
        return 'imagejpeg';
      case 'image/png':
        return 'imagepng';
    }
    throw new \UnexpectedValueException("unexpected file type " . $mimeType);
  }
}
