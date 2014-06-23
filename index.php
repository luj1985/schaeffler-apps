<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();
$app->contentType('application/json');
$app->add(new \Slim\Middleware\HttpBasicAuth(array(
  "path" => "/admin",
  "realm" => "Schaeffler Protected",
  "users" => array(
    "root" => "t00r",
    "user" => "passw0rd"
  )
)));
$db = new PDO('sqlite:db/schaeffler_apps.db');

$app->get('/files/:id', function($id) use ($db, $app) {
  $stmt = $db->prepare('select * from files where id = :id');
  $rs = $stmt->execute(array(':id' => $id));
  if ($file = $stmt->fetch()) {
    http_send_content_disposition($file['filename'], true);
    http_send_content_type("application/octet-stream");
    http_send_file($file['location']);

    $stmt = $db->prepare('update files set count = count + 1 where id = :id');
    $stmt->execute(array(':id' => $id));

  } else {
    $app->contentType('text/html');
    $app->pass();
  }
});


$app->group('/admin/api', function() use ($app, $db) {
  
  $app->get('/files', function () use ($db) {
    $sth = $db->query('select * from files;');
    echo json_encode($sth->fetchAll(PDO::FETCH_CLASS));
  });

  $app->get('/files/:id', function($id) use ($app,$db) {
    $sth = $db->prepare('select * from files where id = ? limit 1;');
    $sth->execute([intval($id)]);
    $rs = $sth->fetchAll(PDO::FETCH_CLASS);
    if ($rs) {
      echo json_encode($rs[0]);
    } else {
      $app->pass(); // 404
    }
  });
  
//  $app->post('/files', function () use ($db, $app) {
//    $sth = $db->prepare('INSERT INTO files (name, filename, location) VALUES (?, ?, ?);');
//    $json = json_decode($app->request()->getBody());
//    $sth->execute([ 
//      $json->name,
//      $json->filename,
//      $json->location
//    ]);
//    echo json_encode([
//      'action' => 'add',
//      'success' => $sth->rowCount() == 1,
//      'id' => $db->lastInsertId(),
//    ]);
//  });
//
//  $app->delete('/files/:id', function($id) use ($db) {
//    $sth = $db->prepare('delete from files where id = ?;');
//    $sth->execute([intval($id)]);
//    
//    echo json_encode([
//      'action' => 'delete',
//      'success' => $sth->rowCount() == 1,
//      'id' => $id
//    ]);
//  });
  
  $app->put('/files/:id', function($id) use ($db, $app) {
    $sth = $db->prepare('update files set name = ?, filename = ?, location = ? WHERE id = ?;');
    $json = json_decode($app->request()->getBody());
    
    $sth->execute([
      $json->name,
      $json->filename,
      $json->location,
      intval($id),
    ]);
    echo json_encode([
      'action' => 'edit',
      'success' => $sth->rowCount() == 1,
      'id' => $id
    ]);
  });
  
  $app->post('/upload', function() {
    if ($_FILES["file"]["error"] > 0) {
      echo 'has error';
      echo json_encode([
        'success' => false,
        'message' => 'Invalid file'
      ]);
    } else {
      $upload_dir = './uploads';
      $filename = $_FILES["file"]["name"];
      $file_path = $_FILES["file"]["tmp_name"];
      $new_file_path = "$upload_dir/$filename";      
      move_uploaded_file($file_path, $new_file_path);            
      echo json_encode([ 'filename' => $filename, 'location' => $new_file_path ]);
    }
  });
});

$app->run();
?>