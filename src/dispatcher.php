<?php

require_once 'controllers.php';

const REDIRECT_PREFIX = 'redirect:';

class Dispatcher
{
  private $routing;

  /**
   * @param $routing
   */
  public function __construct($routing)
  {
    $this->routing = $routing;
  }

  public function dispatch($action_url)
  {
    $controller_name = $this->routing[$action_url];
    syslog(LOG_INFO, "stefan: dispatching: " . $action_url . " ==> " . $controller_name);

    $model = [];
    $view_name = $controller_name($model);

    $this->build_response($view_name, $model);
  }

  private function build_response($view, $model)
  {
    if (strpos($view, REDIRECT_PREFIX) === 0) {
      $url = substr($view, strlen(REDIRECT_PREFIX));
      header("Location: " . $url);
      return;
    } else {
      $this->render($view, $model);
    }
  }

  private function render($view_name, $model)
  {
    extract($model);
    include 'views/' . $view_name . '.php';
  }
}
