<?php

namespace controllers;

require '../utils/WaiDb.php';

use utils\DataBase;
use utils\WaiDb;

abstract class Controller
{
  protected $db;

  /**
   * @param DataBase|null $db
   */
  public function __construct(DataBase $db = null)
  {
    if (!isset($db)) {
      $db = new WaiDb();
    }
    $this->db = $db;
  }

  abstract public function processRequest(array &$model);

  abstract public function getView(): string;

  public function getRedirection(): array
  {
    return [false, ""];
  }

  public function isResponseBuilt(): bool
  {
    return false;
  }

  protected function isUserLogged(): bool
  {
    return isset($_SESSION['user']);
  }

  protected static function serializeParams(&$params): string
  {
    $serialized = "";
    $i = 0;
    foreach ($params as $param => $value) {
      if ($i != 0) {
        $serialized .= '&';
      }
      $serialized .= $param . '=' . $value;
      $i++;
    }
    return $serialized;
  }

}
