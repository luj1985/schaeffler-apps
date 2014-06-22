<!DOCTYPE html>
<html>

<head>
  <title>Admin Console</title>
  <link rel="stylesheet" type="text/css" href="../components/require.css" />
  <script src="../components/require.js"></script>
</head>

<body>
  <div class="container">
    <table id="files" class="table table-striped table-hover table-condensed">
      <thead>
        <th>名字</th>
        <th>下载文件名</th>
        <th>存储位置</th>
        <th>下载次数</th>
        <th></th>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
  <script>
    require(['admin/app']);
  </script>
</body>

</html>