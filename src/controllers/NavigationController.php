<?php

namespace controllers;

use controllers\Controller;

class NavigationController extends Controller
{

    public function processRequest(array &$model)
    {

      $menuEntries = [
        'main' => 'Strona główna',
        'games' => 'Gry',
        'gallery' => 'Galeria',
        'gallery-chosen' => "Galeria - wybrane",
        'image-search' => "Szukajka",
      ];

      if($this->isUserLogged()) {
        $menuEntries['logout'] = 'Wyloguj';
      } else {
        $menuEntries['login'] = 'Zaloguj';
      }
      $model['menuEntries'] = $menuEntries;

      if(!array_key_exists('active', $model)){
        $model['active'] = "";
      }
    }

    public function getView(): string
    {
      return "partial_views/nav_view";
    }
}
