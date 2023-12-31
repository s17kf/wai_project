<?php

namespace utils;

require 'UsersDb.php';

use MongoDB\BSON\PackedArray;
use utils\UsersDb;
use function PHPUnit\Framework\isTrue;

class UsersDbImpl implements UsersDb
{
  private $db;

  /**
   * @param $db
   */
  public function __construct(DataBase $db)
  {
    $this->db = $db->getDb();
  }

  public function saveUser(string $email, string $login, string $passwordHash): bool
  {
    // TODO: Implement saveUser() method.
    if ($this->isUserWithLogin($login) || $this->isUserWithEmail($email)) {
      return false;
    }
    $insertData = [
      'email' => $email,
      'login' => $login,
      'passwordHash' => $passwordHash,
    ];
    $this->db->users->insertOne($insertData);
    return true;
  }


  public function getPasswordHash(string $login): string
  {
    // TODO: Implement getPassphrase() method.
    return "xd";
  }

  public function isUserWithLogin(string $login): bool
  {
    return $this->db->users->findOne(['login' => $login]) !== null;
  }

  public function isUserWithEmail(string $email): bool
  {
    return $this->db->users->findOne(['email' => $email]) !== null;
  }


}
