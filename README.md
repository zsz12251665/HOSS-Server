# HomeworkServer

This is a homework collecting server built for the 2019 Selected Class of Computer Science in SCUT.

[toc]

## 文件说明

- `README.md`、`LICENCE`：说明文档与开源协议
- `index.php`：文件选择、上传页面（默认页面）
- `upload.php`：上传表单提交、文件收容页面
- `sql.php`：MySQL数据库对接函数
- `local.php`：配置服务器参数（需自行创建，详见`配置文件`）
- `admin.php`：管理员功能（打包下载作业、执行修改操作）页面
- `download.php`：提交下载表单、打包下载作业页面
- `modify.php`：提交修改表单、执行修改操作页面
- `404.html`：404错误页面
- `.htaccess`、`.gitignore`：apache与git相关文件
- `css/`、`img/`：样式表文件夹及图片资源文件夹
- `favicon.ico`：网站图标

## 配置文件

`$_SERVER[DOCUMENT_ROOT]/local.php`

```php
<?php
	$admin_password = "[admin_password]";
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

### v1.0 内测

- 增加了管理页面及打包下载页面
- 增加了用户指引
- 重写了MySQL数据库调用

### 快照2020-0422-2343

- 美化了上传页面
- 增加了404错误页面
- 修复了一位学生可以提交多个后缀名各不相同的文件的BUG
- TO-DO：增加管理页面及打包下载页面

### 快照2020-0421-1108

- ~~修复了大文件无法上传的bug（目前单文件上限4GB）~~
- 将存储目录放入配置文件（`local.php`）中
- 在README中增加了注意事项
- 将作业目录加入MySQL数据库

### 快照2020-0420-2210

- 连接了MySQL数据库
- 上传了学生元数据（姓名+学号）
- 增加了上传时的身份验证（姓名+学号）
- 修改了上传目录
- 实现了自动新建作业目录

### 快照2020-0420-0042

- 完成了上传页面（主页）
- 初步完成了上传文件功能
- 存储文件夹的权限需要手动设置
- TO-DO：增加上传身份验证
