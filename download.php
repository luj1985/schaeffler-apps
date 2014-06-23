<?php
$db = new PDO('sqlite:db/schaeffler_apps.db');
$db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Schaeffler Mobile App Download</title>
  </head>
  <body>
<?php
  echo '<ul>';
  $files = $db->query ( 'select * from files' );
  foreach ( $files as $row ) {
    echo '<li>';
    $id = $row['id'];
    echo "<a href=\"/files/$id\">" . (string) $row['name'] . '</a>';
    echo '</li>';
  }
  echo '</ul>';
?>
  </body>
</html>

<?php
$db = null;
?>