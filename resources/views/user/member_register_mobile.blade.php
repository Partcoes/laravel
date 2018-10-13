<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>用户注册</title>
		<base href="{{URL::asset('css/user/user')}}"></base>
		<link rel="stylesheet" type="text/css" href="login.css">
		<script type="text/javascript" src="{{URL::asset('js/jquery-1.8.0.min.js')}}"></script>
		<style type="text/css">
			.message{
				color:red !important;
			}
			.regway{
				color:orange;
			}			
		</style>
	</head>
	<body>
		<form  method="post" action="{{route('regtel')}}">
		<div class="regist">
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<div class="regist_center">
				<div class="regist_top">
					<div class="left fl">会员(<a class="regway" href="{{url('user/register')}}">邮箱注册</a>)</div>
					<div class="right fr"><a href="{{url('index/index')}}" target="_self">小米商城</a></div>
					<div class="clear"></div>
					<div class="xian center"></div>
				</div>
				<div class="regist_main center">
					<div class="username">用&nbsp;&nbsp;户&nbsp;&nbsp;名:&nbsp;&nbsp;<input class="shurukuang" type="text" name="username" placeholder="请输入你的用户名"/><span class='message'>@if(is_object($errors)){{$errors -> first('username')}}@endif</span></div>
					<div class="username">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;&nbsp;<input class="shurukuang" type="password" name="password" placeholder="请输入你的密码"/><span class='message'>@if(is_object($errors)){{$errors -> first('password')}}@endif</span></div>
					
					<div class="username">确认密码:&nbsp;&nbsp;<input class="shurukuang" type="password" name="repassword" placeholder="密码由6-16位数字字母下划线组成哦！"/><span class='message'>@if(is_object($errors)){{$errors -> first('repassword')}}@endif</span></div>
					<div class="username">手&nbsp;&nbsp;机&nbsp;&nbsp;号:&nbsp;&nbsp;<input class="shurukuang" type="text" name="mobile" placeholder="您的手机号码吧，方便我们联系您！"/><span class='message'>@if(is_object($errors)){{$errors -> first('mobile')}}@endif</span></div>
					<div class="username">
						<div class="left fl">验&nbsp;&nbsp;证&nbsp;&nbsp;码:&nbsp;&nbsp;<input class="yanzhengma" type="text" name="validate" placeholder="请输入验证码"/></div>
						<div class="right fl"><img src="{{captcha_src()}}" onclick="this.src='{{captcha_src()}}'+Math.random()"><span class='message'>@if(is_object($errors)){{$errors -> first('validate')}}@endif</span></div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="regist_submit">
					<input class="submit" type="submit" value="立即注册" >
				</div>
				
			</div>
		</div>
		</form>
	</body>
</html>
<script type="text/javascript">
$("input[name='username']").blur(function(){
		var username = $(this).val();
		var reg = /^[a-zA-Z0-9]{6,12}$/;
		if (reg.test(username)) {
			$(this).next('span').text(' ');
			$(this).next('span').html("<b style='color:green;margin-left:20px;'>√</b>");
		}else{
            $(this).next('span').text(' ');
            $(this).next('span').html("<b style='color:orange;margin-left:20px;'>用户名由6-12位数字字母组成</b>");
		}
	})

	$("input[name='password']").blur(function(){
		var password = $(this).val();
		var reg = /^(?=.*?[0-9])[a-zA-Z0-9\.\=\+\*\%\$\#\@]{6,16}$/;
		var reg1 = /^[a-zA-Z0-9\.\=\+\*\%\$\#\@]{6,16}$/;
		if (reg.test(password)) {
            $(this).next('span').text(' ');
			$(this).next('span').html("<b style='color:green;margin-left:20px;'>√</b>");
		}else if(reg1.test(password)){
            $(this).next('span').text(' ');
			$(this).next('span').html("<b style='color:orange;margin-left:20px;'>至少包含一个数字</b>");
		}else{
            $(this).next('span').text(' ');
			$(this).next('span').html("<b style='color:orange;margin-left:20px;'>密码由6-16位数字字母以及.+=%$#@*组成</b>");
		}
	})	
	$("input[name='repassword']").blur(function(){
		var repassword = $(this).val();
		var password = $("input[name='password']").val();
		if (repassword == password && repassword != '') {
			$(this).next('span').text(' ');
			$(this).next('span').html("<b style='color:green;margin-left:20px;'>√</b>");
		}else{
			$(this).next('span').text(' ');
			$(this).next('span').html("<b style='color:orange;margin-left:20px;'>两次密码不一致！</b>");
		}
	})	

	$("input[name='mobile']").blur(function(){
		var moboile = $(this).val();
		var reg = /^1[34578][0-9]{9}$/;
		if (reg.test(moboile)) {
			$(this).next('span').text(' ');
			$(this).next('span').html("<b style='color:green;margin-left:20px;'>√</b>");
		}else{
			$(this).next('span').text(' ');
			$(this).next('span').html("<b style='color:orange;margin-left:20px;'>请输入规范的手机号！</b>");
		}
	})
</script>