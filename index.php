<!DOCTYPE html>
<html lang="zh">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta name="viewport" content="width=device-width" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" />
		<title>SCUT 2019计科全英联合班作业提交系统</title>
	</head>
	<body>
		<main>
			<h1>SCUT 2019计科全英联合班作业提交系统</h1>
			<h4>注意事项</h4>
			<ul>
				<li>每人每份作业只能提交一个文件；</li>
				<li>提交新文件会覆盖掉旧文件；</li>
				<li>如果要提交多个文件，请打包后再提交；</li>
				<li><del>请不要尝试输入稀奇古怪的东西</del>{{{(&gt;_&lt;)}}}</li>
			</ul>
			<form action="/upload.php" method="post" enctype="multipart/form-data">
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
<?php
	require "sql.php";
	foreach (array_reverse($GLOBALS["homeworkList"]) as $homework)
	{
		$directory = htmlspecialchars($homework["directory"] ? $homework["directory"] : $homework["title"]);
		$title = htmlspecialchars($homework["title"]);
		echo "<option value=\"" . $directory . "\">" . $title . "</option>";
	}
?>
					</select>
				</section>
				<section>
					<?php session_start(); ?>
					<label for="WorkFile">作业文件：</label>
					<input type="hidden"
						name="<?php echo ini_get('session.upload_progress.name'); ?>"
						value="test" />
					<input type="file" name="WorkFile" id="WorkFile" target="hidden_iframe"/>
				</section>
				<section style="text-align: center;">
					<input type="submit" name="Submit" id="Submit" />
				</section>
			</form>
			<!-- the progress -->
			<iframe id="hidden_iframe" name="hidden_iframe" src="about:blank" style="display:none;"></iframe>
			<div id="progress" class="progress" style="margin-bottom:15px;display:none;">
					<div class="bar" style="width:0%;"></div>
					<div class="label">0%</div>
			</div>
		</main>
	</body>
</html>
<?php
	function fetch_progress(){
			$.get('progress.php',{ '' : 'test'}, function(data){
					var progress = parseInt(data);
					$('#progress .label').html(progress + '%');
					$('#progress .bar').css('width', progress + '%');

					if(progress < 100){
							setTimeout('fetch_progress()', 100);
					}else{
				$('#progress .label').html('完成!');
			}
			}, 'html');
	}

	$('#upload-form').submit(function(){
			$('#progress').show();
			setTimeout('fetch_progress()', 100);
	});
?>