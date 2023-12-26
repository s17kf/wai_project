<!DOCTYPE html>
<html lang="pl">

<?php require '../routing.php'?>
<head>
  <meta charset="UTF-8">
  <title>Gry planszowe i karciane</title>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
<div id="wrapper">
  <header>
    <h1>Gry planszowe i karciane</h1>
  </header>
  <div id="content">
    <p>
      GD info:
      <ul>
        <?php foreach(gd_info() as $key => $value): ?>
          <li><?= $key ?> => <?= $value ?></li>
        <?php endforeach ?>
    </ul>
    </p>
    <form action="odbierz.php" method="post">
      <table class="survey_table">
        <tr>
          <td>
            <label for="userName">Nazwa użytkownika:</label>
          </td>
          <td>
            <input type="text" name="userName" id="userName">
          </td>
        </tr>
        <tr>
          <td>
            <label for="gameName">Nazwa gry:</label>
          </td>
          <td>
            <input type="text" name="gameName" id="gameName">
          </td>
        </tr>
        <tr>
          <td>
            <label for="gameDescription">Opis gry:</label>
          </td>
          <td>
            <textarea name="gameDescription" id="gameDescription" cols="30" rows="3"></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <label for="gameType">Typ gry</label>
          </td>
          <td>
            <select name="gameType" id="gameType">
              <option value="0">Wybierz rodzaj gry</option>
              <option value="board">planszowa</option>
              <option value="card">karciana</option>
            </select>
            <a id="whatType" href="#" style="display: none">Jaki rodzaj wybrać?</a>
            <div id="dialog" title="jaki rodzaj gry wybrać" style="display: none">
              <p>Jeżeli w grze możliwe jest wykonanie akcji bez użycia karty wybierz gra planszowa.</p>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            Odpowiednia dla dzieci:
          </td>
          <td>
            <label for="kids-yes">tak</label>
            <input type="radio" name="size" id="kids-yes" value="tak">
            <br>
            <label for="kids-no">nie</label>
            <input type="radio" name="size" id="kids-no" value="no">
          </td>
        </tr>
        <tr>
          <td rowspan="3">
          </td>
          <td>
            <input type="checkbox" name="extensions" id="extensions">
            <label for="extensions">Dostępne dodatki do gry.</label>
          </td>
        </tr>
        <tr>
          <td>
            <input type="checkbox" name="polish" id="polish">
            <label for="polish">Gra dostępna w języku polskim.</label>
          </td>
        </tr>
        <tr>
          <td>
            <input type="submit" id="submit" value="Wyślij">
            <input type="reset" id="reset" value="Wyczyść">
          </td>
        </tr>
      </table>
    </form>
  </div>
  <?php (new Dispatcher($routing))->dispatch('/nav') ?>
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
  $("#whatType").show();
  $("#whatType").click(
    (function () {
      $("#dialog").dialog();
    })
  );
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
