define(['jquery', 'backbone', 'underscore', 
        'jquery-file-upload/jquery.iframe-transport',
        'jquery-file-upload/jquery.fileupload'
  ], function($, Backbone, _) {
  var Module = { 
    views : {} 
  };
  
  Module.Model = Backbone.Model.extend({
    idAttribute: "id"
  });
  
  Module.FileCollection = Backbone.Collection.extend({
    url : '/admin/api/files',
    model: Module.Model
  });
  
  Module.views.FileView = Backbone.View.extend({
    tagName : 'tr',
    events : {
      'click .btn.edit' : 'edit',
      'click .btn.finish' : 'finish'
    },
    initialize : function() {
      this.model.on('sync', this.render, this);
    },
    edit: function() {
      var model = this.model;
      $(this.el).html([
        '<td><input type="text" class="app-name" value="' + model.get('name') + '"/></td>',
        '<td><input type="text" class="app-filename" value="' + model.get('filename') + '"/></td>',
        '<td>',
          '<input type="text" class="app-location" value="' + model.get('location') + '" disabled/>',
          '<span class="app-progress"></span>',
          '<input type="file" class="app-upload" />',
        '</td>',
        '<td>' + model.get('count') + '</td>',
        '<td colspan="2"><a class="btn btn-primary btn-xs finish">完成</a></td>'
      ].join(''));
      
      $progress = this.$('.app-progress');
      
      var view = this;
      this.$('.app-upload').fileupload({
        dataType : 'json',
        url: '/admin/api/upload',
        paramName : 'file',
        type : 'POST',
        done : function(e, data) {
          var result = data.result,
              filename = result.filename,
              location = result.location;
          view.$('.app-filename').val(filename);
          view.$('.app-location').val(location);
        },
        progressall: function (e, data) {
          var progress = parseInt(data.loaded / data.total * 100, 10);
          $progress.html(progress + "%");
          if (progress === 100) {
            $progress.html('');
          }
        }
      });
    },
    finish: function() {
      this.model.set({
        name : this.$('.app-name').val(),
        filename : this.$('.app-filename').val(),
        location : this.$('.app-location').val()
      });
      this.model.save();
      this.render();
    },
    render : function() {
      $(this.el).html([
        '<td>' + this.model.get('name') + '</td>',
        '<td>' + this.model.get('filename') + '</td>',
        '<td>' + this.model.get('location') + '</td>',
        '<td>' + this.model.get('count') + '</td>',
        '<td><a class="btn btn-primary btn-xs edit">编辑</a></td>'
      ].join(''));
      return this;
    }
  });
  
  Module.views.FileListView = Backbone.View.extend({
    initialize : function() {
      this.collection.on('sync', this.render, this);
    },
    render : function() {
      var el = this.$('tbody');
      el.empty();
      this.collection.each(function(model) {        
        var view = new Module.views.FileView({model: model});
        el.append(view.render().el);
      }, this);
      return this;
    }
  });
  return Module;
});