<?php

namespace utils;

interface UsersDb
{
  public function saveUser(string $email, string $login, string $passwordHash): bool;

  public function getUserDataById(string $id);

  public function getUserDataByLogin(string $login);

  public function getPasswordHash(string $login): string;

  public function isUserWithLogin(string $login): bool;

  public function isUserWithEmail(string $email): bool;
}
