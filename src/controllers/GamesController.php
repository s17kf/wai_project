<?php

namespace controllers;

class GamesController extends Controller
{
  public function processRequest(array &$model)
  {
  }

  public function getView(): string
  {
    return 'games_view';
  }

}
