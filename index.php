<?php session_start(); ?>
<!DOCTYPE html>
<html lang="zh">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta name="viewport" content="width=device-width" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" />
		<title>SCUT 2019计科全英联合班作业提交系统</title>
		<script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
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
			<form id="upload-form" action="/upload.php" method="post" enctype="multipart/form-data" target="hidden_iframe">
				<input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="test" />
				<section>
					<label for="StuName">学生姓名：</label>
					<input type="text" name="StuName" id="StuName" required="required" />
				</section>
				<section>
					<label for="StuNumber">学生学号：</label>
					<input type="text" name="StuNumber" id="StuNumber" required="required" />
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
					<label for="WorkFile">作业文件：</label>
					<input type="file" name="WorkFile" id="WorkFile" required="required" />
				</section>
				<section style="text-align: center;">
					<input type="submit" name="Submit" id="Submit" />
				</section>
			</form>
			<div id="progress" style="display: none;">
				<div class="bar" style="width: 0%;"></div>
				<div class="label">0%</div>
			</div>
		</main>
		<iframe id="hidden_iframe" name="hidden_iframe" src="about:blank" style="display: none;"></iframe>
		<script type="text/javascript">
function fetch_progress()
{
	$.get('progress.php', {'<?php echo ini_get("session.upload_progress.name"); ?>' : 'test'}, function(data)
	{
		var progress = parseInt(data);
		$('#progress .label').html(progress < 100 ? progress + '%' : '完成');
		$('#progress .bar').css('width', progress + '%');
		if (progress < 100)
		{
			setTimeout('fetch_progress()', 1000);
		}
	}, 'html');
}

$('#upload-form').submit(function()
{
	$('#progress').show();
	setTimeout('fetch_progress()', 1000);
});
		</script>
	</body>
</html>
