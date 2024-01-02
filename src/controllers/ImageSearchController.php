<?php

namespace controllers;

require_once 'Controller.php';

class ImageSearchController extends Controller
{

  public function processRequest(array &$model)
  {
  }

  public function getView(): string
  {
    return 'image_search_view';
  }
}
