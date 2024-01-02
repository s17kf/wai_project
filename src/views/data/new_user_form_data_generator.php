<?php

require '../utils/FormEntry.php';
require '../utils/FormEntryWarned.php';

use \utils\FormEntry;
use utils\FormEntryWarned;


$newUserFormEntriesData = [
  new FormEntryWarned($newUserValidationWarnings['email'] ?? null,
    "Adres e-mail:", "e-mail", "e-mail", "text", ['value' => $email ?? ""]),
  new FormEntryWarned($newUserValidationWarnings['login'] ?? null,
    "Login:", "new_login", "login", "text", ['value' => $new_login ?? ""]),
  new FormEntryWarned($newUserValidationWarnings['password'] ?? null,
    "Hasło:", "new_password", "password", "password"),
  new FormEntryWarned($newUserValidationWarnings['password-repeated'] ?? null,
    "Powtórz hasło:", "password-repeated", "password-repeated", "password"),
  new FormEntry("", "submit-button", "submit-button", "submit", ['value' => 'Utwórz konto']),
];

$loginEntriesData = [
  new FormEntry("Login:", "login", "login", "text", ['value' => $login ?? ""]),
  new FormEntry("Hasło:", "password", "password", "password"),
  new FormEntry("", "submit-button", "submit-button", "submit", ['value' => 'Zaloguj']),
];
