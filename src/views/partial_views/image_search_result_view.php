<?php if (isset($images)): ?>
  <div class="gallery-grid-container">
    <?php foreach ($images as $image): ?>
      <div class="gallery-grid-item">
        <table>
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
      <!-- TODO: style for navigation table -->
      <tr>
        <td>
          <?= $currentDisplayed['begin'] ?> - <?= $currentDisplayed['end'] ?> z <?= $currentDisplayed['total'] ?>
        </td>
        <?php foreach ($paginationData['navigationLinks'] as $navigationLink): ?>
          <?php foreach ($navigationLink as $text => $link): ?>
            <td class="gallery-pagination">
              <?php if ($link != ""): ?>
                <a href="#" class="gallery-pagination-link<?php if ($text == $currentPage) {
                  echo ' active';
                } ?>"
                onclick="loadDoc(<?= $link ?>)">
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
<?php else: ?>
  <p>Nie znaleziono pasującuch obrazów.</p>
<?php endif ?>

