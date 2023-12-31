<?php

namespace utils;

class FormWarning
{
  private $id;
  private $warning;

  /**
   * @param string $id
   * @param string $warning
   */
  public function __construct(string $id, string $warning)
  {
    $this->id = $id;
    $this->warning = $warning;
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function getWarning(): string
  {
    return $this->warning;
  }



}
