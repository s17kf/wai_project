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

  protected function generatePaginationLinks(int $currentPage, int $totalPages, string $destPage): array
  {
    $navigationLinks = [];
    if ($currentPage > 1) {
      $navigationLinks[] = ['<' => $destPage . '?page=' . ($currentPage - 1)];
      $navigationLinks[] = [1 => $destPage . '?page=' . 1];
    } else {
      $navigationLinks[] = ['<' => ""];
      $navigationLinks[] = [1 => ""];
    }
    if ($currentPage > 3) {
      $navigationLinks[] = ['...' => ""];
    }
    if ($currentPage > 2) {
      $navigationLinks[] = [$currentPage - 1 => $destPage . '?page=' . ($currentPage - 1)];
    }
    if ($currentPage != 1 and $currentPage != $totalPages) {
      $navigationLinks[] = [$currentPage => ""];
    }
    if ($currentPage < $totalPages - 1) {
      $navigationLinks[] = [$currentPage + 1 => $destPage . '?page=' . ($currentPage + 1)];
    }
    if ($currentPage < $totalPages - 2) {
      $navigationLinks[] = ['...' => ""];
    }
    if ($currentPage < $totalPages) {
      $navigationLinks[] = [$totalPages => $destPage . '?page=' . $totalPages];
      $navigationLinks[] = ['>' => $destPage . '?page=' . ($currentPage + 1)];
    } else {
      if ($totalPages > 1) {
        $navigationLinks[] = [$totalPages => ""];
      }
      $navigationLinks[] = ['>' => ""];
    }
    return $navigationLinks;
  }

  protected function generateCurrentDisplayedData(int $currentPage, int $imagesCount): array
  {
    return [
      'begin' => ($currentPage - 1) * IMAGES_PER_PAGE + 1,
      'end' => min(($currentPage - 1) * IMAGES_PER_PAGE + IMAGES_PER_PAGE, $imagesCount),
      'total' => $imagesCount,
    ];
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
