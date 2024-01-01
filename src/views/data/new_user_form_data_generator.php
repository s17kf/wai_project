<?php

require '../utils/FormEntry.php';

use \utils\FormEntry;


$newUserFormEntriesData = [
  new FormEntry("Adres e-mail:", "e-mail", "e-mail", "text", ['value' => $email ?? ""],
    true, $newUserValidationWarnings['email'] ?? null),
  new FormEntry("Login:", "new_login", "login", "text", ['value' => $new_login ?? ""],
    true, $newUserValidationWarnings['login'] ?? null),
  new FormEntry("Hasło:", "new_password", "password", "password", [],
    true, $newUserValidationWarnings['password'] ?? null),
  new FormEntry("Powtórz hasło:", "password-repeated", "password-repeated", "password", [],
    true, $newUserValidationWarnings['password-repeated'] ?? null),
  new FormEntry("", "submit-button", "submit-button", "submit", ['value' => 'Utwórz konto']),
];

$loginEntriesData = [
  new FormEntry("Login:", "login", "login", "text", ['value' => $login ?? ""]),
  new FormEntry("Hasło:", "password", "password", "password"),
  new FormEntry("", "submit-button", "submit-button", "submit", ['value' => 'Zaloguj']),
];
