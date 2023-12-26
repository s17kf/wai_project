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

    <div>
      <?php if (!empty($images)): ?>
        <div class="gallery-grid-container">
          <?php foreach ($images as $image): ?>
            <div class="gallery-grid-item">
              <img src="<?= $image['src'] ?>" class="gallery-item" alt="<?= $image['src'] ?>">
            </div>
          <?php endforeach ?>
        </div>
        <div>
          <p>
            <?= $currentDisplayed['begin'] ?> - <?= $currentDisplayed['end'] ?> z <?= $currentDisplayed['total'] ?>
          </p>
          <table>
            <!-- TODO: style for navigation table -->
            <tr>
              <?php foreach ($paginationData['navigationLinks'] as $navigationLink): ?>
                <?php foreach ($navigationLink as $text => $link): ?>
                  <td>
                    <?php if ($link != ""): ?>
                      <a href="<?= $link ?>" <?php if ($text == $currentPage) {
                        echo 'class="active"';
                      } ?> >
                        <?= $text ?>
                      </a>
                    <?php else: ?>
                      <?= $text ?>
                    <?php endif ?>
                  </td>
                <?php endforeach ?>
              <?php endforeach ?>
            </tr>
          </table>
        </div>
      <?php endif ?>
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

<?php if (!empty($errors)): ?>
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
