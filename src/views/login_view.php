<!doctype html>
<html lang="pl">

<?php include_once '../constants.php' ?>
<?php require '../routing.php' ?>
<?php require '../utils/FormEntry.php' ?>
<?php require '../utils/FormEntryWarned.php' ?>

<?php use utils\FormEntry; ?>
<?php use utils\FormEntryWarned; ?>
<head>
  <meta charset="utf-8">
  <title>Gry planszowe i karciane</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="static/css/style.css">
</head>

<body>
<div id="wrapper">
  <header>
    <h1>Gry planszowe i karciane</h1>
  </header>
  <div id="content">
    <?php
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

    ?>
    <div id="login_form_container">
      <?php if (isset($logged_out)): ?>
        <p class="form-ok-notification">Wylogowano!</p>
      <?php endif ?>
      <h1>Zaloguj się</h1>
      <?php if (isset($login_failed)): ?>
        <p class="form_error">Login lub hasło niepoprawne!</p>
      <?php endif ?>
      <form name="login_form" id="login_form" method="post">
        <input type="hidden" name="form_id" id="form_id" value="login">
        <?php
        (new Dispatcher($routing))->dispatch('/form-table', ['formEntriesData' => $loginEntriesData]);
        ?>
      </form>
      <?php if (isset($newUserError)): ?>
        <div id="errorDialog" title="Nie udało się utworzyć konta!" style="display: none">
          <p><?= $newUserError ?></p>
        </div>
      <?php endif ?>
      <?php if (isset($newUserAdded)): ?>
        <div id="newUserInfoDialog" title="Konto zostało utworzone" style="display: none">
          <p>Konto użytkownika <?= $newUserAdded ?> zostało utworzone.</p>
        </div>
      <?php endif ?>
    </div>
    <div id="new_user_form_container">
      <h1>Zarejestruj się</h1>
      <form name="new_user_form" id="new_user_form" method="post" onsubmit="return validateNewUserForm()">
        <input type="hidden" name="form_id" id="form_id_id" value="new_user">
        <?php
        (new Dispatcher($routing))->dispatch('/form-table', ['formEntriesData' => $newUserFormEntriesData]);
        ?>
      </form>
      <?php if (isset($newUserError)): ?>
        <div id="errorDialog" title="Nie udało się utworzyć konta!" style="display: none">
          <p><?= $newUserError ?></p>
        </div>
      <?php endif ?>
      <?php if (isset($newUserAdded)): ?>
        <div id="newUserInfoDialog" title="Konto zostało utworzone" style="display: none">
          <p>Konto użytkownika <?= $newUserAdded ?> zostało utworzone.</p>
        </div>
      <?php endif ?>
    </div>
  </div>

  <?php (new Dispatcher($routing))->dispatch('/nav', ['active' => 'login']) ?>

</div>
<footer id="foot">
  <div id="date"></div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="js/navigation_dynamic.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function (ev) {
    console.log("DOM fully loaded and parsed");
    addMouseHoverEffect();
  })
</script>

<?php if (isset($newUserError)): ?>
  <script>
    $('#errorDialog').show();
    $('#errorDialog').dialog();
  </script>
<?php endif ?>

<?php if (isset($newUserAdded)): ?>
  <script>
    $('#newUserInfoDialog').show();
    $('#newUserInfoDialog').dialog();
  </script>
<?php endif ?>

<script>
  function validateNewUserForm() {
    let form = document.forms["new_user_form"];
    let email = form['e-mail'].value;
    let login = form['login'].value;
    let password = form['password'].value;
    let passwordRepeated = form['password-repeated'].value;
    const loginRegex = /^[a-z0-9_]+$/i;
    const emailRegex = /^[a-z0-9.+]+@[a-z0-9]+.[a-z]+$/i;
    const passwordMinLength = 4;

    let alerts = ["Formularz zawiera błędy:"];
    if (!email.match(emailRegex)) {
      alerts.push(" - podany email jest niepoprawny!")
    }
    if (!login.match(loginRegex)) {
      alerts.push(" - login zawiera niedozwolone znaki!")
    }
    if (password.length < passwordMinLength) {
      alerts.push(" - hasło jest za krótkie!");
    }
    if (password !== passwordRepeated) {
      alerts.push(" - powtórzone hasło jest inne!")
    }

    if (alerts.length > 1) {
      alert(alerts.join("\n"));
      return false;
    }
    return true;
  }
</script>

<script>
  let dt = new Date();
  let time = ('0' + dt.getDate()).slice(-2) + "." +
    ('0' + (dt.getMonth() + 1)).slice(-2) + "." +
    dt.getFullYear() + " " +
    ('0' + dt.getHours()).slice(-2) + ":" +
    ('0' + dt.getMinutes()).slice(-2) + ":" +
    ('0' + dt.getSeconds()).slice(-2);
  $('#date').text(time)
</script>

</body>

</html>
