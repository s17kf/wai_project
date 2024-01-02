<!doctype html>
<html lang="pl">

<?php include_once '../constants.php' ?>
<?php require '../routing.php' ?>

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
    <h1>Jesteś zalogowany</h1>
    Twoje dane:
    <ul>
      <li>login: <?= $login ?></li>
      <li>e-mail: <?= $email ?></li>
    </ul>
    <a href="gallery">Przejdź do galerii</a>
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
