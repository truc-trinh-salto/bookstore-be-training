<?php
echo '<ul>';
foreach ($books as $book) {
  echo '<li>
    <a href="#">' . $book->title . '</a>
  </li>';
}
echo '</ul>';
?>
