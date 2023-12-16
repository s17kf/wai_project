<?php

require_once 'controllers.php';

const REDIRECT_PREFIX = 'redirect:';

function dispatch($routing, $action_url)
{
  $controller_name = $routing[$action_url];

  syslog(LOG_INFO, "stefan: dispatching: " . $action_url . " ==> " . $controller_name);

  $model = [];
  $view_name = $controller_name($model);


  build_response($view_name, $model);
}

function build_response($view, $model)
{
  if (strpos($view, REDIRECT_PREFIX) === 0) {
    $url = substr($view, strlen(REDIRECT_PREFIX));
    header("Location: " . $url);
    exit;

  } else {
    render($view, $model);
  }
}

function render($view_name, $model)
{
  global $routing;
  extract($model);
  include 'views/' . $view_name . '.php';
}
