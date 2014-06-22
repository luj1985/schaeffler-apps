<?php
try {
  $dbh = new PDO('sqlite:db/schaeffler_apps.db');
  $dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $dbh->prepare('select * from files where id = :id');
    $rs = $stmt->execute(array(':id' => $id));
    if ($file = $stmt->fetch()) {
      http_send_content_disposition($file['filename'], true);
      http_send_content_type("application/octet-stream");
      http_send_file($file['location']);
      
      $stmt = $dbh->prepare('update files set count = count + 1 where id = :id');
      $stmt->execute(array(':id' => $id));
    } else {
      header('HTTP/1.1 404 Not Found'); 
      echo '404 Not Found';
    }
    return;
  }
} catch ( PDOException $e ) {
  echo 'ERROR: ' . $e->getMessage ();
  die();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Schaeffler Mobile App Download</title>
  </head>
  <body>
<?php
  echo '<ul>';
  $files = $dbh->query ( 'select * from files' );
  foreach ( $files as $row ) {
    echo '<li>';
    $id = $row['id'];
    echo "<a href=\"download.php?id=$id\">" . (string) $row['name'] . '</a>';
    echo '</li>';
  }
  echo '</ul>';
?>
  </body>
</html>

<?php
$dbh = null;
?>