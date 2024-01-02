<?php

namespace controllers;

use controllers\Controller;
use utils\GalleryDb;
use utils\GalleryDbImpl;

abstract class AbstractGalleryController extends Controller
{
  protected $userId;

  public function __construct()
  {
    parent::__construct();
    $this->userId = $_SESSION['user'] ?? null;
  }

  protected function getImagesAndPaginationData(array &$model, string $destPage, array $dbFilter = null)
  {
    $galleryDb = new GalleryDbImpl($this->db);
    $page = $_GET['page'] ?? 1;
    $imagesCount = $galleryDb->getImagesCount($this->userId, $dbFilter);
    if ($imagesCount === 0) {
      return;
    }
    $paginationData = $this->generatePaginationData($page, $imagesCount, $destPage);
    if ($page > $paginationData['totalPages']) {
      $page = $paginationData['totalPages'];
    }
    $model['currentPage'] = $page;
    $model['paginationData'] = $paginationData;
    $model['currentDisplayed'] = $this->generateCurrentDisplayedData($page, $imagesCount);;
    $model['images'] = $this->getImagesData($galleryDb, $page, $dbFilter);
  }

  private function getImagesData(GalleryDb &$galleryDb, int $page, array $userFilter = null): array
  {
    $images = $this->getImagesOnPage($galleryDb, $page, $userFilter);
    $imagesData = [];
    foreach ($images as $image) {
      $imagesData[] = $this->getImageData($image);
    }
    return $imagesData;
  }

  private function getImagesOnPage(GalleryDb &$galleryDb, int $page, array $userFilter = null)
  {
    $skip = ($page - 1) * IMAGES_PER_PAGE;
    $limit = IMAGES_PER_PAGE;
    return $galleryDb->getImagesData(['skip' => $skip, 'limit' => $limit], $this->userId, $userFilter);
  }

  private function getImageData($image): array
  {
    return [
      'id' => $image['_id'],
      'src' => IMAGES_DIRS['mini'] . '/' . $image['name'],
      'title' => $image['title'] ?? "",
      'author' => $image['author'] ?? "",
      'private' => isset($image['private']),
    ];
  }

  protected function generatePaginationData(int $currentPage, int $imagesCount, string $destPage): array
  {
    $pages = ceil($imagesCount / IMAGES_PER_PAGE);
    if ($currentPage > $pages) {
      $currentPage = $pages;
    }
    $navigationLinks = $this->generatePaginationLinks($currentPage, $pages, $destPage);

    return [
      'navigationLinks' => $navigationLinks,
      'totalPages' => $pages,
    ];
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
}
