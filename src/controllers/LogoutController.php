<?php

namespace controllers;

use controllers\Controller;

class LogoutController extends Controller
{

    public function processRequest(array &$model)
    {
      unset($_SESSION['user']);
      $model["logged_out"] = true;
    }

    public function getView(): string
    {
      return "login_view";
    }
}
