<?php

namespace controllers;

use controllers\Controller;

class FormTableController extends Controller
{

  public function processRequest(array &$model)
  {
    $formEntriesData = $model['formEntriesData'];
    $formEntries = [];
    foreach ($formEntriesData as $entryData) {
      $formEntries[$entryData->getLabelEntry()] = $entryData->getInputEntry();
    }
    $model['formEntries'] = $formEntries;
  }

  public function getView(): string
  {
    return "partial_views/form_table_view";
  }
}
