<?php

namespace controllers;

require '../utils/FormWarning.php';
require '../utils/UsersDbImpl.php';
require '../utils/WaiDb.php';

use utils\FormWarning;
use utils\UsersDb;
use utils\UsersDbImpl;
use utils\WaiDb;

class LoginController extends Controller
{
  const OK = 0;
  const NOT_VALID = 1;
  const NAME_ALREADY_USED = 2;

  const EMAIL_WARNINGS = [
    self::NOT_VALID => "Email jest niepoprawny!",
    self::NAME_ALREADY_USED => "Podany adres e-mail jest już zarejestrowany!",
  ];

  const LOGIN_WARNINGS = [
    self::NOT_VALID => "Login zawiera niedozwolone znaki",
    self::NAME_ALREADY_USED => "Użytkownik o podanym loginie już istnieje!",
  ];

  const PASSWORD_WARNINGS = [
    self::NOT_VALID => "Hasło nie spełnia wymagań!",
  ];

  const PASSWORD_REPEATED_WARNINGS = [
    self::NOT_VALID => "Hasła różnią się!"
  ];

  private $redirectUrl = "";

  public function getRedirection(): array
  {
    return [$this->redirectUrl != "", $this->redirectUrl];
  }


  public function processRequest(array &$model)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->processPostRequest($model);
      return;
    }
    $this->processGetRequest($model);
  }

  public function getView(): string
  {
    return 'login_view';
  }

  private function processPostRequest(array &$model)
  {
    $usersDb = new UsersDbImpl(new WaiDb());
    if ($_POST['form_id'] === 'new_user') {
      $params = [];
      if (!$this->validateNewUserData($params, $usersDb)) {
        $params['email'] = urlencode($_POST['e-mail']);
        $params['login'] = urlencode($_POST['login']);
        $this->redirectUrl = "login?" . self::serializeParams($params);
        return;
      }
      if ($this->addNewUser($usersDb)) {
        $this->redirectUrl = "login?userAdded=" . $_POST['login'];
        return;
      }
      $model['newUserError'] = "Nie udało się utworzyć konta! Spróbuj ponownie lub skontaktuj się z administratorem strony.";
      $model['email'] = $_POST['e-mail'];
      $model['login'] = $_POST['login'];
    }
  }

  private function processGetRequest(array &$model)
  {
    $fields = ['email', 'login'];
    foreach ($fields as $field) {
      if (key_exists($field, $_GET)) {
        $model[$field] = $_GET[$field];
      }
    }
    $newUserValidationWarnings = [];
    $validationCodes = $_GET['warnings'] ?? null;
    if ($validationCodes) {
      $validationCodes = explode(',', $validationCodes);
      $emailValidation = $validationCodes[0];
      $loginValidation = $validationCodes[1];
      $passwordValidation = $validationCodes[2];
      $passwordRepeatedValidation = $validationCodes[3];
      system_log($emailValidation);
      if ($emailValidation != self::OK) {
        $newUserValidationWarnings['email'] = new FormWarning('email-warning', self::EMAIL_WARNINGS[$emailValidation]);
      }
      if ($loginValidation != self::OK) {
        $newUserValidationWarnings['login'] = new FormWarning('login-warning', self::LOGIN_WARNINGS[$loginValidation]);
      }
      if ($passwordValidation != self::OK) {
        $newUserValidationWarnings['password'] =
          new FormWarning('password-warning', self::PASSWORD_WARNINGS[$passwordValidation]);
      }
      if ($passwordRepeatedValidation != self::OK) {
        $newUserValidationWarnings['password-repeated'] =
          new FormWarning('password-repeated-warning', self::PASSWORD_REPEATED_WARNINGS[$passwordRepeatedValidation]);
      }
    }
    $model['newUserValidationWarnings'] = $newUserValidationWarnings;
    if (key_exists('userAdded', $_GET)) {
      $model['newUserAdded'] = $_GET['userAdded'];
    }
  }


  private function addNewUser(UsersDb &$usersDb): bool
  {
    $email = $_POST['e-mail'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    return $usersDb->saveUser($email, $login, $passwordHash);
  }

  private function validateNewUserData(array &$params, UsersDb &$usersDb): bool
  {
    $email = $_POST['e-mail'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $passwordRepeated = $_POST['password-repeated'];
    $emailValidationResult = $this->validateEmail($email, $usersDb);
    $loginValidationResult = $this->validateLogin($login, $usersDb);
    $passwordValidationResult = $this->validatePassword($password);
    $passwordRepeatedValidationResult = $this->validatePasswordRepeated($password, $passwordRepeated);
    if ($emailValidationResult + $loginValidationResult + $passwordValidationResult + $passwordRepeatedValidationResult
      != self::OK) {
      $params['warnings'] = sprintf("%d,%d,%d,%d",
        $emailValidationResult,
        $loginValidationResult,
        $passwordValidationResult,
        $passwordRepeatedValidationResult);
      return false;
    }
    return true;
  }

  private function validateEmail(string $email, UsersDb &$usersDb): int
  {
    $emailRegex = "/^[a-z0-9.+]+@[a-z0-9]+.[a-z]+$/i";
    if (!preg_match($emailRegex, $email)) {
      return self::NOT_VALID;
    }
    if ($usersDb->isUserWithEmail($email)) {
      return self::NAME_ALREADY_USED;
    }
    return self::OK;
  }

  private function validateLogin(string $login, UsersDb &$usersDb): int
  {
    $loginRegex = "/^[a-z0-9_]+$/i";
    if (!preg_match($loginRegex, $login)) {
      return self::NOT_VALID;
    }
    if ($usersDb->isUserWithLogin($login)) {
      return self::NAME_ALREADY_USED;
    }
    return self::OK;
  }

  private function validatePassword(string $password): int
  {
    if (strlen($password) < 4) {
      return self::NOT_VALID;
    }
    return self::OK;
  }

  private function validatePasswordRepeated(string $password, string $passwordRepeated): int
  {
    if ($password !== $passwordRepeated) {
      return self::NOT_VALID;
    }
    return self::OK;
  }
}