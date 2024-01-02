<?php

namespace utils;

require '../../vendor/autoload.php';
require 'DataBase.php';

class WaiDb implements DataBase
{
  private $db;

  /**
   * @param $db
   */
  public function __construct()
  {
    $mongo = new \MongoDB\Client(
      "mongodb://localhost:27017/wai",
      [
        'username' => 'wai_web',
        'password' => 'w@i_w3b',
      ]);

    $this->db = $mongo->wai;
  }

  /**
   * @return \MongoDB\Database
   */
  public function getDb(): \MongoDB\Database
  {
    return $this->db;
  }
}
