<?php

require '../utils/FormEntry.php';

use \utils\FormEntry;


$newUserFormEntriesData = [
  new FormEntry("Adres e-mail:", "e-mail", "e-mail", "text", ['value' => $email ?? ""],
    true, $newUserValidationWarnings['email'] ?? null),
  new FormEntry("Login:", "login", "login", "text", ['value' => $login ?? ""],
    true, $newUserValidationWarnings['login'] ?? null),
  new FormEntry("Hasło:", "password", "password", "password", [],
    true, $newUserValidationWarnings['password'] ?? null),
  new FormEntry("Powtórz hasło:", "password-repeated", "password-repeated", "password", [],
    true, $newUserValidationWarnings['password-repeated'] ?? null),
  new FormEntry("", "submit-button", "submit-button", "submit", ['value' => 'Wyślij']),
];
