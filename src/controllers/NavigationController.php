<?php

namespace controllers;

use controllers\Controller;

class NavigationController extends Controller
{

    public function processRequest(array &$model)
    {
      if(!array_key_exists('active', $model)){
        $model['active'] = "";
      }
    }

    public function getView(): string
    {
      return "partial_views/nav_view";
    }
}
