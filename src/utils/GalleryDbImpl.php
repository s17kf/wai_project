<?php

namespace utils;

require 'GalleryDb.php';

class GalleryDbImpl implements GalleryDb
{
  private $db;

  /**
   * @param $db
   */
  public function __construct(DataBase $db)
  {
    $this->db = $db->getDb();
  }

  public function saveImageData($imageData) {
    $insertStatus = $this->db->gallery->insertOne($imageData);
    return $insertStatus->getInsertedId();
  }


}
