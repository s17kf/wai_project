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
    <div id="searchBar">
      <table>
        <tr>
          <td>
            <label>
              Szukana fraza:
              <input id="searchInput" type="text" onkeyup="loadDoc()">
            </label>
          </td>
          <td style="text-align: left">
            <label>
              Szukane pole:
              <select id="searchField" onchange="loadDoc()">
                <option value="title">tytuł</option>
                <option value="author">autor</option>
              </select>
            </label>
          </td>
        </tr>
      </table>
    </div>
    <div id="searchResult">
    </div>
  </div>

  <?php (new Dispatcher($routing))->dispatch('/nav', ['active' => 'image-search']) ?>

</div>
<footer id="foot">
  <div id="date"></div>
</footer>

<script>
  function loadDoc(page = null) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
      document.getElementById("searchResult").innerHTML = this.responseText;
    }
    let pageParam = "";
    if (page) {
      pageParam = "&page=" + page;
    }
    console.log("onclick: " + pageParam);
    let searchInput = document.getElementById("searchInput").value;
    let searchField = document.getElementById("searchField").value;
    xhttp.open("GET", `image-search-ajax-request?search=${searchInput}&searchField=${searchField}${pageParam}`, true);
    xhttp.send();
  }
</script>

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
