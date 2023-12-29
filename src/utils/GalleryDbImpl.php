<?php

namespace utils;

require 'GalleryDb.php';

use MongoDB\BSON\ObjectID;

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

  public function saveImageData($imageData)
  {
    $insertStatus = $this->db->gallery->insertOne($imageData);
    return $insertStatus->getInsertedId();
  }

  public function getImagesData($options = [])
  {

    return $this->db->gallery->find([], $options)->toArray();
  }

  public function getImage($id)
  {
    return $this->db->gallery->findOne(['_id' => new ObjectID($id)]);
  }

  public function getImagesCount()
  {
    return $this->db->gallery->count();
  }

}
