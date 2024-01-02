<?php

namespace utils;

use utils\FormEntry;

class FormEntryWarned extends FormEntry
{
  private $warning;

  /**
   * @param FormWarning|null $warning
   * @param string $label
   * @param string $id
   * @param string $name
   * @param string $type
   * @param array $attributes
   * @param bool $required
   */
  public function __construct($warning, string $label, string $id, string $name, string $type,
                              array $attributes = [], bool   $required = true)
  {
    parent::__construct($label, $id, $name, $type, $attributes, $required);
    $this->warning = $warning;
  }

  public function getInputEntry(): string
  {
    $entry = parent::getInputEntry();
    if (isset($this->warning)) {
      $warning = sprintf('<span class="form_error" id="%s">%s</span><br>',
        $this->warning->getId(), $this->warning->getWarning());
      $entry = $warning . $entry;
    }
    return $entry;
  }
}
