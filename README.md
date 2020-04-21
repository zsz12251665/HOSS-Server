# HomeworkServer

This is a homework collecting server built for the 2019 Selected Class of Computer Science in SCUT.

## 配置文件

`$_SERVER[DOCUMENT_ROOT]/local.php`

```php
<?php
	$mysql_server = "[mysql_server]";
	$mysql_username = "[mysql_username]";
	$mysql_password = "[mysql_password]";
	$upload_directory = "[upload_directory]"; // Slash required at the end
?>
```

## 注意事项

1. MySQL数据库需使用UTF-8编码
2. PHP文件传输上限需（在`php.ini`中）按需上调（[参考](https://www.php.cn/php-ask-430566.html)）

## 开发日志

### 快照2020-0420-0042

- 完成了上传页面（主页）
- 初步完成了上传文件功能
- 存储文件夹的权限需要手动设置
- TO-DO：增加上传身份验证

### 快照2020-0420-2210

- 连接了MySQL数据库
- 上传了学生元数据（姓名+学号）
- 增加了上传时的身份验证（姓名+学号）
- 修改了上传目录
- 实现了自动新建作业目录

### 快照2020-0421-1108

- ~~修复了大文件无法上传的bug（目前单文件上限4GB）~~
- 将存储目录放入配置文件（`local.php`）中
- 在README中增加了注意事项
- 将作业目录加入MySQL数据库
