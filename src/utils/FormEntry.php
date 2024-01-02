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
  private $checked;

  /**
   * @param string $label
   * @param string $id
   * @param string $name
   * @param string $type
   * @param array $attributes
   * @param bool $required
   * @param bool $checked
   */
  public function __construct(string $label, string $id, string $name, string $type, array $attributes = [],
                              bool   $required = true, bool $checked=false)
  {
    $this->label = $label;
    $this->id = $id;
    $this->name = $name;
    $this->type = $type;
    $this->attributes = $attributes;
    $this->required = $required;
    $this->checked = $checked;
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
    if ($this->checked) {
      $entry .= ' checked';
    }
    $entry .= ">";
    return $entry;
  }


}
