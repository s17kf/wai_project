<?php

namespace controllers;

use controllers\Controller;

class LogoutController extends Controller
{
  public function getRedirection(): array
  {
    return [true, "login?logged_out"];
  }


  public function processRequest(array &$model)
    {
      unset($_SESSION['user']);
    }

    public function getView(): string
    {
      return "login_view";
    }
}
