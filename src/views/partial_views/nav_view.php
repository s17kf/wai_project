<?php
$menuEntries = [
  'main' => 'Strona główna',
  'games' => 'Gry',
  'survey' => 'Ankieta',
  'gallery' => 'Galeria',
]
?>

<nav id="navMenu">
  <ul>
    <?php
    foreach ($menuEntries as $action => $toShow) {
      $entry = '<li><a href="' . $action . '">' . $toShow . '</a></li>';
      echo $entry;
    }
    ?>
  </ul>
</nav>
