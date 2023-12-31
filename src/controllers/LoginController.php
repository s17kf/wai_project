<?php

namespace controllers;

require '../utils/FormWarning.php';

use controllers\Controller;
use utils\FormWarning;

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
    if ($_POST['form_id'] === 'new_user') {
      $params = [];
      if (!$this->validateNewUserData($params)) {
        $params['email'] = $_POST['e-mail'];
        $params['login'] = $_POST['login'];
        $this->redirectUrl = "login?" . self::serializeParams($params);
      }
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
  }

  private function validateNewUserData(array &$params)
  {
    $email = $_POST['e-mail'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $passwordRepeated = $_POST['password-repeated'];
    $emailValidationResult = $this->validateEmail($email);
    $loginValidationResult = $this->validateLogin($login);
    $passwordValidationResult = $this->validatePassword($password);
    $passwordRepeatedValidationResult = $this->validatePasswordRepeated($password, $passwordRepeated);
    if ($emailValidationResult + $loginValidationResult + $passwordValidationResult + $passwordRepeatedValidationResult
      != self::OK) {
      $params['warnings'] = sprintf("%d,%d,%d,%d",
        $emailValidationResult,
        $loginValidationResult,
        $passwordValidationResult,
        $passwordRepeatedValidationResult);
    }
    return false;
  }

  private function validateEmail(string $email): int
  {
    $emailRegex = "/^[a-z0-9.+]+@[a-z0-9]+.[a-z]+$/i";
    if (!preg_match($emailRegex, $email)) {
      return self::NOT_VALID;
    }
    return self::OK;
  }

  private function validateLogin(string $email): int
  {
    $loginRegex = "/^[a-z0-9_]+$/i";
    if (!preg_match($loginRegex, $email)) {
      return self::NOT_VALID;
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
