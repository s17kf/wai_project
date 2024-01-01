<?php

namespace utils;

class FormEntry
{

  private $label;
  private $id;
  private $type;
  private $name;
  private $attributes;
  private $required;
  private $warning;

  /**
   * @param string $label
   * @param string $id
   * @param string $name
   * @param string $type
   * @param array $attributes
   * @param bool $required
   * @param FormWarning|null $warning
   */
  public function __construct(string $label, string $id, string $name, string $type, array $attributes = [],
                              bool   $required = true, FormWarning $warning = null)
  {
    $this->label = $label;
    $this->id = $id;
    $this->name = $name;
    $this->type = $type;
    $this->attributes = $attributes;
    $this->required = $required;
    $this->warning = $warning;
  }

  public function getLabelEntry(): string
  {
    if ($this->label === "") {
      return "";
    }
    return sprintf("<label for='%s'>%s</label>", $this->id, $this->label);
  }

  public function getInputEntry(): string
  {
    $entry = sprintf('<input name="%s" id="%s" type="%s"', $this->name, $this->id, $this->type);
    foreach ($this->attributes as $key => $value) {
      $entry .= sprintf(' %s="%s"', $key, $value);
    }
    if ($this->required) {
      $entry .= ' required';
    }
    $entry .= ">";
    if ($this->warning != "") {
      $warning = sprintf('<span class="form-warning" id="%s">%s</span><br>',
          $this->warning->getId(), $this->warning->getWarning());
      $entry = $warning . $entry;
    }
    return $entry;
  }


}
