<?php

namespace utils;

require 'UsersDb.php';

use MongoDB\BSON\ObjectId;

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

  public function getUserDataById(string $id)
  {
    return $this->db->users->findOne(['_id' => new ObjectId($id)]);
  }

  public function getUserDataByLogin(string $login)
  {
    return $this->db->users->findOne(['login' => $login]);
  }


  public function getPasswordHash(string $login): string
  {
    return $this->db->users->findOne(['login' => $login])->passwordHash;
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
