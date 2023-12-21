<?php

function serialize_params(&$params)
{
  $serialized = "";
  $i = 0;
  foreach ($params as $param => $value) {
    if ($i != 0) {
      $serialized .= '&';
    }
    $serialized .= $param . '=' . $value;
    $i++;
  }
  return $serialized;
}
