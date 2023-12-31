<?php

require '../utils/FormEntry.php';

use \utils\FormEntry;

$uploadImageFormEntriesData = [
  new FormEntry("Wybierz plik:", "uploaded_image_id", "uploaded_image", "file",
    ['accept' => 'image/jpeg, image/png']),
  new FormEntry("Znak wodny:", "watermark", "watermark", "text"),
  new FormEntry("Tytuł:", "title", "title", "text", [], false),
  new FormEntry("Autor", "author", "author", "text", [], false),
  new FormEntry("", "submit-button", "submit-button", "submit", ['value' => 'Wyślij']),
];
