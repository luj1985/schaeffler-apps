<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Schaeffler Admin Console</title>
  <link rel="stylesheet" type="text/css" href="components/require.css" />
  <script src="components/require.js"></script>
</head>

<body>
  <div class="container" style="margin-top:50px;">
    <table id="files" class="table table-striped table-hover table-condensed">
      <thead>
        <th>名字</th>
        <th>存储位置</th>
        <th>下载文件名</th>
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