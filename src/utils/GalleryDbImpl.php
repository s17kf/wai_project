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

  public function getImagesData($options = [], string $loggedUserId = null, array $userFilter = null)
  {
    $filter = $this->generateAccessFilter($loggedUserId);
    if (isset($userFilter)) {
      $filter = [
        '$and' => [$filter, $userFilter]
      ];
    }
    return $this->db->gallery->find($filter, $options)->toArray();
  }

  public function getImage($id)
  {
    return $this->db->gallery->findOne(['_id' => new ObjectID($id)]);
  }

  public function getImagesCount(string $loggedUserId = null, array $userFilter = null)
  {
    $filter = $this->generateAccessFilter($loggedUserId);
    if (isset($userFilter)) {
      $filter = [
        '$and' => [$filter, $userFilter]
      ];
    }
    return $this->db->gallery->count($filter);
  }

  private function generateAccessFilter(string $loggedUserId = null): array
  {
    $publicFilter = [
      'private' => [
        '$not' => [
          '$exists' => '',
        ],
      ],
    ];
    if (!isset($loggedUserId)) {
      return $publicFilter;
    }
    $privateFilter = [
      'private' => [
        '$regex' => "^" . $loggedUserId . '$',
      ],
    ];
    return [
      '$or' => [$publicFilter, $privateFilter],
    ];
  }

}
