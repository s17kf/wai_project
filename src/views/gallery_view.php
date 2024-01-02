<!doctype html>
<html lang="pl">

<?php
include_once '../constants.php';
require '../routing.php';
require '../utils/FormEntry.php';

use \utils\FormEntry;

?>


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
    <?php if (isset($upload_image_form) && $upload_image_form): ?>
      <?php
      $authorAttributes = $userInfo->isUserLogged() ? ['value' => $userInfo->getUserLogin()] : [];
      $uploadImageFormEntriesData = [
        new FormEntry("Wybierz plik:", "uploaded_image_id", "uploaded_image", "file",
          ['accept' => 'image/jpeg, image/png']),
        new FormEntry("Znak wodny:", "watermark", "watermark", "text"),
        new FormEntry("Tytuł:", "title", "title", "text"),
        new FormEntry("Autor", "author", "author", "text", $authorAttributes),
      ];
      if ($userInfo->isUserLogged()) {
        $uploadImageFormEntriesData[] =
          new FormEntry("Publiczne:", "private-no", "private", "radio", ['value' => 'no'], true, true);
        $uploadImageFormEntriesData[] =
          new FormEntry("Prywatne:", "private-yes", "private", "radio", ['value' => 'yes']);
      }
      $uploadImageFormEntriesData[] =
        new FormEntry("", "submit-button", "submit-button", "submit", ['value' => 'Wyślij']);
      ?>
      <?php if (!empty($infos)): ?>
        <div>
          <?php foreach ($infos as $info): ?>
            <p class="form-ok-notification"><?= $info ?></p>
          <?php endforeach ?>
        </div>
      <?php endif ?>
      <div>
        <input id="show_image_upload_form_button" type="button" value="Pokaż formularz dodawania zdjęć"
               onclick="showImageUploadForm()">
        <input id="hide_image_upload_form_button" type="button" value="Ukryj formularz dodawania zdjęć"
               onclick="hideImageUploadForm()" style="display: none">
      </div>
      <div id="image_upload_form_container" style="display: none">
        <form enctype="multipart/form-data" method="post">
          <input type="hidden" name="MAX_FILE_SIZE" value="<?= GALLERY_IMAGE_MAX_SIZE ?>"/>
          <input type="hidden" name="form_id" id="form_id" value="add_image">
          <input type="hidden" name="page" id="page" value="<?= $currentPage ?>">
          <?php
          (new Dispatcher($routing))->dispatch('/form-table', ['formEntriesData' => $uploadImageFormEntriesData]);
          ?>
        </form>
      </div>
    <?php endif ?>

    <div>
      <?php if (!empty($images)): ?>
        <?php $memory_form_id = 'memory_form' ?>
        <div class="gallery-grid-container">
          <?php foreach ($images as $image): ?>
            <div class="gallery-grid-item">
              <table>
                <tr>
                  <td>
                    <label>
                      <?= $image_checkbox ?>
                      <input type="checkbox" name="checked_images[]" value="<?= $image['id'] ?>"
                             form="<?= $memory_form_id ?>"
                        <?php
                        if (isset($usersChosenImages) && in_array($image['id'], $usersChosenImages))
                          echo 'checked'
                        ?>
                      >
                    </label>
                  </td>
                </tr>
                <tr>
                  <td>
                    <a href="image?img=<?= $image['id'] ?>&page=<?= $currentPage ?>&return=<?= $action ?>">
                      <img src="<?= $image['src'] ?>" class="gallery-item" alt="<?= $image['src'] ?>">
                    </a>
                  </td>
                </tr>
                <?php if ($image['private']): ?>
                  <tr>
                    <td>
                      <span class="form-warning">Prywatne!</span>
                    </td>
                  </tr>
                <?php endif ?>
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
              <td>
                <input type="submit" value="<?= $memory_form_submit ?>" form="<?= $memory_form_id ?>">
              </td>
            </tr>
          </table>
        </div>
        <form id="<?= $memory_form_id ?>" method="post">
          <input type="hidden" name="form_id" id="form_id" value="memory_images">
          <input type="hidden" name="page" id="page" value="<?= $currentPage ?>">
        </form>
      <?php endif ?>
    </div>
  </div>

  <?php (new Dispatcher($routing))->dispatch('/nav', ['active' => $active ?? ""]) ?>

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

<?php if (isset($upload_failed) && $upload_failed): ?>
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

<?php if (isset($upload_failed) && $upload_failed): ?>
  <script>
    $("#errorDialog").show();
    $("#errorDialog").dialog();
  </script>
<?php endif ?>

<script>
  function showImageUploadForm() {
    console.log("show image upload form");
    $('#image_upload_form_container').show();
    $('#show_image_upload_form_button').hide();
    $('#hide_image_upload_form_button').show();
  }

  function hideImageUploadForm(image) {
    console.log("hide image upload form");
    $('#image_upload_form_container').hide();
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
