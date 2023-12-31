<?php
$menuEntries = [
  'main' => 'Strona główna',
  'games' => 'Gry',
  'survey' => 'Ankieta',
  'gallery' => 'Galeria',
  'login' => 'Zaloguj',
  // TODO: handle somehow login <-> log out
]
?>

<nav id="navMenu">
  <ul>
    <?php
    foreach ($menuEntries as $action => $toShow) {
      $active_entry_part = $active === $action ? ' class="active"' : '';
      $entry = '<li><a href="' . $action . '"' . $active_entry_part . '>' . $toShow . '</a></li>';
      echo $entry;
    }
    ?>
  </ul>
</nav>
