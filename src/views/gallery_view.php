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
    <h1>Galeria</h1>
  </header>
  <div id="content">
    <?php if (!empty($infos)): ?>
      <div>
        <?php foreach ($infos as $info): ?>
          <p><?= $info ?></p>
        <?php endforeach ?>
      </div>
    <?php endif ?>
    <form enctype="multipart/form-data" method="post">
      <input type="hidden" name="MAX_FILE_SIZE" value="<?= GALLERY_IMAGE_MAX_SIZE ?>"/>
      Wybierz plik:
      <input name="uploaded_image" id="uploaded_image_id" type="file" accept="image/jpeg, image/png" required>
      <br>
      <label>
        <span>Znak wodny: </span>
        <input name="watermark" type="text" required>
      </label>
      <br>
      <input type="submit" value="Wyślij">
    </form>
    <?php if ($upload_failed): ?>
      <div id="errorDialog" title="Nie udało się wysłać zdjęcia" style="display: none">
        <?php if (!empty($errors)): ?>
          <p>Błędy:</p>
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?= $error ?></li>
            <?php endforeach ?>
          </ul>
        <?php endif ?>
        <?php if (!empty($warnings)): ?>
          <p>Ostrzerzenia:</p>
          <ul>
            <?php foreach ($warnings as $warning): ?>
              <li><?= $warning ?></li>
            <?php endforeach ?>
          </ul>
        <?php endif ?>
      </div>
    <?php endif ?>

    <div class="text-center">
      <button id="back_to_gallery_button">Powrót do galerii</button>
    </div>
    <img class="maximized" src="static/img/catan.png" alt="Zdjęcie gra Catan" id="catan_full_img"
         onclick="cloaseMaximized(this)">
    <img class="maximized" src="static/img/catan-inside01.png" alt="Zdjęcie gra Catan w środku"
         id="catan_inside_full_image"
         onclick="cloaseMaximized(this)">
    <img class="maximized" src=static/img/cytadela.jpg alt="Zdjęcie gra Cytadela" id="cytadela_full_img"
         onclick="cloaseMaximized(this)">
    <img class="maximized" src=static/img/cytadela_cards_coins_crown.png alt="Zdjęcie gra Cytadela - karty i monety"
         id="cytadela_cards_coins_crown_full_img" onclick="cloaseMaximized(this)">
    <img class="maximized" src=static/img/cytadela_characters_cards.png alt="Zdjęcie gra Cytadela - karty postaci"
         id="cytadela_characters_cards_full_img" onclick="cloaseMaximized(this)">
    <img class="maximized" src=static/img/terraformacja_marsa.jpg alt="Zdjęcie gra Terraformacja Marsa"
         id="terraformacja_marsa_full_img" onclick="cloaseMaximized(this)">
    <img class="maximized" src=static/img/odjechane_jednorozce.jpg alt="Zdjęcie gra Odjechane jednorożce"
         id="odjechane_jednorozce_full_img" onclick="cloaseMaximized(this)">

    <div class="gallery-grid-container" id="gallery_grid">
      <div class="gallery-grid-item" onclick="maximizeImage('catan_full_img')">
        <img src="static/img/catan.png" class="gallery-item" alt="Zdjęcie gra Catan">
      </div>
      <div class="gallery-grid-item" onclick="maximizeImage('catan_inside_full_image')">
        <img src="static/img/catan-inside01.png" class="gallery-item" alt="Zdjęcie gra Catan w środku">
      </div>
      <div class="gallery-grid-item" onclick="maximizeImage('cytadela_full_img')">
        <img src="static/img/cytadela.jpg" class="gallery-item" alt="Zdjęcie gra Cytadela">
      </div>
      <div class="gallery-grid-item" onclick="maximizeImage('cytadela_cards_coins_crown_full_img')">
        <img src="static/img/cytadela_cards_coins_crown.png" class="gallery-item"
             alt="Zdjęcie gra Cytadela - karty i monety">
      </div>
      <div class="gallery-grid-item" onclick="maximizeImage('cytadela_characters_cards_full_img')">
        <img src="static/img/cytadela_characters_cards.png" class="gallery-item"
             alt="Zdjęcie gra Cytadela - karty postaci">
      </div>
      <div class="gallery-grid-item" onclick="maximizeImage('terraformacja_marsa_full_img')">
        <img src="static/img/terraformacja_marsa.jpg" class="gallery-item" alt="Zdjęcie gra Terraformacja Marsa">
      </div>
      <div class="gallery-grid-item" onclick="maximizeImage('odjechane_jednorozce_full_img')">
        <img src="static/img/odjechane_jednorozce.jpg" class="gallery-item" alt="Zdjęcie gra Odjechane jednorożce">
      </div>
    </div>
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

<?php if(!empty($errors)): ?>
  <script>
    $("#errorDialog").dialog();
  </script>
<?php endif ?>

<script>
  function maximizeImage(id) {
    if (outerWidth <= 600) {
      return;
    }
    console.log("maximize: " + id);
    let maximizedImage = document.getElementById(id);
    maximizedImage.style.display = 'block';
    document.getElementById("gallery_grid").style.display = 'none';
    let backToGalleryButton = document.getElementById("back_to_gallery_button");
    backToGalleryButton.style.display = 'inline-block';
    backToGalleryButton.onclick = function () {
      cloaseMaximized(maximizedImage)
    }
  }

  function cloaseMaximized(image) {
    image.style.display = 'none';
    document.getElementById('gallery_grid').style.display = 'inline-grid';
    document.getElementById("back_to_gallery_button").style.display = 'none';
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
