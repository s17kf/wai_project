<?php

namespace controllers;

abstract class Controller
{

  abstract public function processRequest(&$model): void;

  abstract public function getView(): string;

  public function getRedirection(): array
  {
    return [false, ""];
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
