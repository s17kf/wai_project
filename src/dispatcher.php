<?php

use controllers\Controller;

require_once 'controllers/Controller.php';
include_once 'system_log.php';

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

  public function dispatch(string $action_url, $model = [])
  {
    $controller = $this->getController($action_url);
    syslog(LOG_INFO, "stefan: dispatching: " . $action_url . " ==> " . get_class($controller));

    $controller->processRequest($model);
    $this->build_response($controller, $model);
  }

  private function build_response(Controller &$controller, array &$model)
  {
    $redirectionData = $controller->getRedirection();
    $shouldRedirect = $redirectionData[0];
    $redirectionUrl = $redirectionData[1];
    if ($shouldRedirect) {
      header("Location: " . $redirectionUrl);
      return;
    }
    $this->render($controller, $model);
  }

  private function render(Controller &$controller, array &$model)
  {
    extract($model);
    include 'views/' . $controller->getView() . '.php';
  }

  private function getController($action): Controller
  {
    $controllerName = $this->routing[$action];
    require_once 'controllers/' . $controllerName . '.php';
    $controllerFullName = 'controllers\\' . $controllerName;
    return new $controllerFullName();
  }
}
