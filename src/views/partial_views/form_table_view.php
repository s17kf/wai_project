<table class="survey_table">
  <?php foreach ($formEntries as $label => $input): ?>
    <tr>
      <td>
        <?= $label ?>
      </td>
      <td>
        <?= $input ?>
      </td>
    </tr>
  <?php endforeach ?>
</table>
