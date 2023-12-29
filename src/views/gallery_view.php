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
    <div>
      <input id="show_image_upload_form_button" type="button" value="Pokaż formularz dodawania zdjęć"
             onclick="showImageUploadForm()">
      <input id="hide_image_upload_form_button" type="button" value="Ukryj formularz dodawania zdjęć"
             onclick="hideImageUploadForm()" style="display: none">
    </div>
    <div id="image_upload_form" style="display: none">
      <form enctype="multipart/form-data" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= GALLERY_IMAGE_MAX_SIZE ?>"/>
        <table class="survey_table">
          <tr>
            <td>
              Wybierz plik:
            </td>
            <td>
              <input name="uploaded_image" id="uploaded_image_id" type="file" accept="image/jpeg, image/png" required>
            </td>
          </tr>
          <tr>
            <td>
              <label for="watermark">Znak wodny:</label>
            </td>
            <td>
              <input name="watermark" id="watermark" type="text" required>
            </td>
          </tr>
          <tr>
            <td>
              <label for="title">Tytuł:</label>
            </td>
            <td>
              <input name="title" id="title" type="text">
            </td>
          </tr>
          <tr>
            <td>
              <label for="author">Autor:</label>
            </td>
            <td>
              <input name="author" id="author" type="text">
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <input type="submit" value="Wyślij">
            </td>
          </tr>
        </table>
      </form>
    </div>
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
              <table>
                <tr>
                  <td>
                    <a href="image?img=<?= $image['id'] ?>&page=<?= $currentPage ?>">
                      <img src="<?= $image['src'] ?>" class="gallery-item" alt="<?= $image['src'] ?>">
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>
                    <?= $image['title'] ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    Author: <?= $image['author'] ?>
                  </td>
                </tr>
              </table>
            </div>
          <?php endforeach ?>
        </div>
        <div>
          <table class="bordered">
            <!-- TODO: style for navigation table -->
            <tr>
              <td>
                <?= $currentDisplayed['begin'] ?> - <?= $currentDisplayed['end'] ?> z <?= $currentDisplayed['total'] ?>
              </td>
              <?php foreach ($paginationData['navigationLinks'] as $navigationLink): ?>
                <?php foreach ($navigationLink as $text => $link): ?>
                  <td class="gallery-pagination">
                    <?php if ($link != ""): ?>
                      <a href="<?= $link ?>" class="gallery-pagination-link<?php if ($text == $currentPage) {
                        echo ' active';
                      } ?>">
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
  function showImageUploadForm() {
    console.log("show image upload form");
    $('#image_upload_form').show();
    $('#show_image_upload_form_button').hide();
    $('#hide_image_upload_form_button').show();
  }

  function hideImageUploadForm(image) {
    console.log("hide image upload form");
    $('#image_upload_form').hide();
    $('#show_image_upload_form_button').show();
    $('#hide_image_upload_form_button').hide();
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
