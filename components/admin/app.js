require(['admin/file'], function(App) {
  var files = new App.FileCollection();  
  var listView = new App.views.FileListView({
    el : 'table#files',
    collection : files
  });
  files.fetch();
});