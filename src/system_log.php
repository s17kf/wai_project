<?php

function system_log($log) {
  syslog(LOG_INFO, "stefan: " . $log);
}
