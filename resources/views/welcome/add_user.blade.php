<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="" method="post">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<p>用户名：<input type="text" name="username"></p>
		<p>密码：<input type="password" name="password"></p>
		<p><input type="submit" value="添加"></p>
	</form>
</body>
</html>