schaeffler-apps
===============
用来对schaeffler mobile app文件下载进行计数。


需要的PHP模块
-----------

* openssl.so
* phar.so
* iconv.so
* http.so
* sqlite3.so
* pdo_sqlite.so

安装Composer
-----------
使用[Composer](http://getcomposer.org/)来安装项目依赖。

    composer install
    
代码结构说明
----------

dashboard.php

  是后台管理的界面。使用Backbone.js来渲染html，以及调用对应的REST API
  
download.php

  暴露给终端用户的界面，包括下载链接，分别对应iPhone版和android版
  
index.php

  系统用到的REST API，包括文件上传，文件名更新等。
  
配置
---

REST API使用HTTP Basic Authentication来验证用户身份。
用户名和密码可以在index.php文件中找到。
