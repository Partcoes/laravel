<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>会员登录</title>
		<link rel="stylesheet" type="text/css" href="{{URL::asset('css/user/login.css')}}">
		<style type="text/css">
			.message{
				color:red;
				position: absolute;
				top:40px;
				right: 60px;
				z-index: 20;
			}
		</style>
	</head>
	<body>
		<!-- login -->
		<div class="top center">
			<div class="logo center">
				<a href="./index.html" target="_blank"><img src="{{URL::asset('images/user/mistore_logo.png')}}" alt=""></a>
			</div>
		</div>
		<form  method="post" action="{{route('login')}}" class="form center">
		<div class="login">
			<div class="login_center">
				<div class="login_top">
					<div class="left fl">会员登录</div>
					<div class="right fr">您还不是我们的会员？<a href="{{url('user/register')}}" target="_self">立即注册</a></div>
					<div class="clear"></div>
					<div class="xian center"></div>
				</div>
				<div class="login_main center" >
					@csrf
					<div class="username" style="position: relative;">账&nbsp;&nbsp;&nbsp;&nbsp;号:&nbsp;<input class="shurukuang" type="text" name="acount" placeholder="用户名\手机号\邮箱"/><span class='message'>@if(is_object($errors)){{$errors -> first('acount')}}@endif</span></div>
					
					<div class="username" style="position: relative;">密&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;<input class="shurukuang" type="password" name="password" placeholder="请输入你的密码"/><span class='message'>@if(is_object($errors)){{$errors -> first('password')}}@endif</span></div>
					
					<div class="username"  style='position: relative;'>
						<div class="left fl">验证码:&nbsp;<input class="yanzhengma" type="text" name="validate" placeholder="请输入验证码"/></div>
						<div class="right fl" ><img src="{{captcha_src()}}" onclick="this.src='{{captcha_src()}}'+Math.random()"></div>
						<div class="clear"></div>
						<span class="message" >@if(is_object($errors)){{$errors -> first('validate')}}@endif</span>
					</div>
				</div>

				<div class="login_submit">
					<input class="submit" type="submit" value="立即登录" >
				</div>
			</div>
		</div>
		</form>
		<footer>
			<div class="copyright">简体 | 繁体 | English | 常见问题</div>
			<div class="copyright">小米公司版权所有-京ICP备10046444-<img src="{{URL::asset('images/user/ghs.png')}}" alt="">京公网安备11010802020134号-京ICP证110507号</div>

		</footer>
	</body>
</html>