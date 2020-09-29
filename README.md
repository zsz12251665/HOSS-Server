# HOSS-Server

This is the server script for HOSS (Homework Online Submit System). It is a project for the 2019 Selected Class of Computer Science in SCUT.

## 文件说明

- `admin.php`：管理员功能（打包下载作业、执行修改操作）页面
- `download.php`：提交下载表单、打包下载作业页面
- `homework.php`：获取作业列表及提交人数页面（数据为JSON格式）
- `index.php`：文件选择、上传页面（默认页面）
- `install.php`：快速配置页面（仅初次安装时）
- `local.php`：配置服务器参数页面（**安装时创建**，格式详见`配置文件格式`）
- `modify.php`：提交修改表单、执行修改操作页面
- `sql.php`：MySQL数据库对接函数
- `upload.php`：上传表单提交、文件收容页面
- `404.html`：404错误页面
- `README.md`、`LICENCE`：说明文档与开源协议
- `.htaccess`、`.gitignore`：apache与git相关文件
- `css/`、`img/`、`js/`：样式表文件夹、图片资源文件夹及脚本文件夹
- `favicon.ico`：网站图标

## 配置文件格式

`local.php`

```php
<?php
	$admin_password = "[Admin Password]";
	$mysql_server = "[MySQL Server]";
	$mysql_database = "[MySQL Database]";
	$mysql_username = "[MySQL Username]";
	$mysql_password = "[MySQL Password]";
	$upload_directory = "[Upload Directory]"; // Slash required at the end
	$website_title = "[Website Title]";
?>
```

## 注意事项

1. 本系统**不支持基于IE内核（Trident）的浏览器**（包括部分浏览器的“兼容模式”）
2. MySQL数据库需使用UTF-8编码（[参考](https://zhuanlan.zhihu.com/p/60605885)）
3. PHP文件传输上限需（在`php.ini`中）按需上调（[参考](https://www.php.cn/php-ask-430566.html)）
4. 安装前请开放脚本相应目录及作业保存目录读写权限，以正确安装及上传文件
5. 温馨提示：在安装phpMyAdmin时，遇到warning可参考[此文](https://phpnotebook.com/phpmyadmin-error-libraries-sql-lib-php-613-count-parameter-must-array-or-object.html)
