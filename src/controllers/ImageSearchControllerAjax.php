<?php

namespace controllers;

require_once 'AbstractGalleryController.php';

class ImageSearchControllerAjax extends AbstractGalleryController
{
  public function processRequest(array &$model)
  {
    $model['action'] = '/image-search';
    $searchPhrase = $_GET['search'] ?? null;
    $searchField = $_GET['searchField'] ?? "name";
    if (!$searchPhrase) {
      return;
    }
    $dbFilter = [
      $searchField => [
        '$regex' =>  $searchPhrase,
        '$options' => 'i',
      ],
    ];
    $destParams = sprintf("search=%s", $searchPhrase);
    $this->setImagesAndPaginationData($model, "image-search-ajax-request", $dbFilter, $destParams);
  }

  public function getView(): string
  {
    return 'partial_views/image_search_result_view';
  }

  protected function generatePaginationLinks(int    $currentPage, int $totalPages, string $destPage,
                                             string $destParams = null): array
  {
    $destParams = isset($destParams) ? '&' . $destParams : "";
    $navigationLinks = [];
    if ($currentPage > 1) {
      $navigationLinks[] = ['<' => ($currentPage - 1)];
      $navigationLinks[] = [1 => 1];
    } else {
      $navigationLinks[] = ['<' => ""];
      $navigationLinks[] = [1 => ""];
    }
    if ($currentPage > 3) {
      $navigationLinks[] = ['...' => ""];
    }
    if ($currentPage > 2) {
      $navigationLinks[] = [$currentPage - 1 => ($currentPage - 1)];
    }
    if ($currentPage != 1 and $currentPage != $totalPages) {
      $navigationLinks[] = [$currentPage => ""];
    }
    if ($currentPage < $totalPages - 1) {
      $navigationLinks[] = [$currentPage + 1 => ($currentPage + 1) ];
    }
    if ($currentPage < $totalPages - 2) {
      $navigationLinks[] = ['...' => ""];
    }
    if ($currentPage < $totalPages) {
      $navigationLinks[] = [$totalPages => $totalPages];
      $navigationLinks[] = ['>' => ($currentPage + 1)];
    } else {
      if ($totalPages > 1) {
        $navigationLinks[] = [$totalPages => ""];
      }
      $navigationLinks[] = ['>' => ""];
    }
    return $navigationLinks;
  }
}

