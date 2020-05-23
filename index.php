<!DOCTYPE html>
<html lang="zh">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta name="viewport" content="width=device-width" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" />
		<title><?php require "local.php"; echo $website_title; ?></title>
	</head>
	<body>
		<main>
			<header>
				<h1><?php require "local.php"; echo $website_title; ?></h1>
			</header>
			<h4>注意事项</h4>
			<ul>
				<li>本系统<strong>不支持基于IE内核（Trident）的浏览器</strong>（包括部分浏览器的“兼容模式”）；</li>
				<li>请将您的浏览器切换至“极速模式”或使用我们推荐的浏览器，并将其更新至最新版本（<a href="https://github.com/zsz12251665/HOSS-Server/issues/3">详见此处</a>）；</li>
				<li>每人每份作业只能提交一个文件，提交新文件会覆盖掉旧文件；</li>
				<li>如果要提交多个文件，请打包后再提交；</li>
				<li>有问题？请<a href="https://github.com/zsz12251665/HOSS-Server/issues/new">告诉我们</a>，或<a href="https://github.com/zsz12251665/HOSS-Server">前往项目</a>帮助我们改进。</li>
			</ul>
			<form action="javascript:void(0)" method="post" enctype="multipart/form-data">
				<section>
					<label for="StuName">学生姓名：</label>
					<input type="text" name="StuName" id="StuName" />
				</section>
				<section>
					<label for="StuNumber">学生学号：</label>
					<input type="text" name="StuNumber" id="StuNumber" />
				</section>
				<section>
					<label for="WorkTitle">作业内容：</label>
					<select name="WorkTitle" id="WorkTitle">
						<option value="Default" selected="selected">--请选择要提交的作业--</option>
					</select>
				</section>
				<section>
					<label for="WorkFile">作业文件：</label>
					<input type="file" name="WorkFile" id="WorkFile" />
				</section>
				<section style="text-align: center;">
					<input type="submit" name="Submit" id="Submit" />
					<div id="Progress" class="progress" style="display: none;">
						<span class="label">0%</span>
						<div class="strip" style="width: 0%;"></div>
					</div>
				</section>
			</form>
			<footer>&copy; 2020 <a href="https://github.com/whaohan">whaohan</a> &amp; <a href="https://github.com/zsz12251665">zsz12251665</a>. All rights reserved. </footer>
		</main>
		<script type="text/javascript" src="/js/index.js"></script>
	</body>
</html>
