<?php

namespace controllers;

abstract class Controller
{

  abstract public function processRequest(array &$model);

  abstract public function getView(): string;

  public function getRedirection(): array
  {
    return [false, ""];
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
