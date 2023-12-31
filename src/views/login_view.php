<!doctype html>
<html lang="pl">

<?php include_once '../constants.php' ?>
<?php require '../routing.php' ?>
<?php require_once 'data/new_user_form_data_generator.php' ?>

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
    <div id="new_user_form_container">
      <h1>Zarejestruj się</h1>
      <form name="new_user_form" id="new_user_form" method="post" onsubmit="return validateNewUserForm()">
        <input type="hidden" name="form_id" id="form_id_id" value="new_user" >
        <?php
        (new Dispatcher($routing))->dispatch('/form-table', ['formEntriesData' => $newUserFormEntriesData]);
        ?>
      </form>
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

<script>
  function validateNewUserForm() {
    return true;
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
    if (password !== passwordRepeated){
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
