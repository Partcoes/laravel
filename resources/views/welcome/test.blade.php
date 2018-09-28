<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>select</title>
</head>
<body>
	@foreach($data as $k => $v)
		<p>{{$v -> goods_name}}</p>
		<p>{{$v -> price}}</p>
	@endforeach
</body>
</html>