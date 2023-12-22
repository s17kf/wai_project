<?php

namespace utils;

class FileSystemHelper
{
  static public function getNextAvailableName($dir, $wanted_name_base, $ext): string
  {
    $checked_filepath = $dir . '/' . $wanted_name_base . '.' . $ext;
    if (!file_exists($checked_filepath)) {
      return $checked_filepath;
    }
    for ($i = 1; $i < MAX_SAME_NAME_FILES; ++$i) {
      $checked_filepath = $dir . '/' . $wanted_name_base . '_' . $i . '.' . $ext;
      if (!file_exists($checked_filepath)) {
        return $checked_filepath;
      }
    }
    throw new \OutOfRangeException("file name not available");
  }

  static public function getMimeType($file)
  {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    return finfo_file($finfo, $file);
  }

}
