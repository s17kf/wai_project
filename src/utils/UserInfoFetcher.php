<?php

namespace utils;

class UserInfoFetcher
{
  private $usersDb;

  /**
   * @param UsersDb $usersDb
   */
  public function __construct(UsersDb $usersDb)
  {
    $this->usersDb = $usersDb;
  }

  public function isUserLogged(): bool
  {
    return isset($_SESSION['user']);
  }

  public function getUserId() {
    return $_SESSION['user'] ?? null;
  }

  public function getUserLogin()
  {
    if (!$this->isUserLogged()) {
      return null;
    }
    return $this->usersDb->getUserDataById($this->getUserId())->login;
  }

}
