@extends('common.template')
	<!-- start header -->
		@section('content')
	<!--end header -->
<!-- start banner_x -->
		<div class="banner_x center">
			<a href="{{url('index/index')}}" target="_blank"><div class="logo fl"></div></a>
			<a href=""><div class="ad_top fl"></div></a>
			<div class="nav fl">
				<ul>
					<li><a href="">小米手机</a></li>
					<li><a href="">红米</a></li>
					<li><a href="">平板·笔记本</a></li>
					<li><a href="">电视</a></li>
					<li><a href="">盒子·影音</a></li>
					<li><a href="">路由器</a></li>
					<li><a href="">智能硬件</a></li>
					<li><a href="">服务</a></li>
					<li><a href="">社区</a></li>
				</ul>
			</div>
			<div class="search fr">
				<form action="" method="post">
					<div class="text fl">
						<input type="text" class="shuru"  placeholder="小米6&nbsp;小米MIX现货">
					</div>
					<div class="submit fl">
						<input type="submit" class="sousuo" value="搜索"/>
					</div>
					<div class="clear"></div>
				</form>
				<div class="clear"></div>
			</div>
		</div>
<!-- end banner_x -->

	<!-- start banner_y -->
	<!-- end banner -->

	<!-- start danpin -->
		<div class="danpin center">
			
			<div class="biaoti center">小米手机</div>
			@if($lists)
				@foreach($lists as $num => $list)
				<div class="main center">
					@foreach($list as $k => $goods)
					<div class="mingxing fl mb20" style="border:2px solid #fff;width:230px;cursor:pointer;" onmouseout="this.style.border='2px solid #fff'" onmousemove="this.style.border='2px solid red'">
						<div class="sub_mingxing"><a href="{{url('index/getdetailbyid/1')}}" target="_blank"><img src="{{$goods['goods_img']}}" alt=""></a></div>
						<div class="pinpai"><a href="./xiangqing.html" target="_blank">{{$goods['goods_name']}}</a></div>
						<div class="youhui">{{$goods['active_brief']}}</div>
						<div class="jiage">{{$goods['shop_price']}}元</div>
					</div>
					@endforeach
					<div class="clear"></div>
				</div>
				@endforeach
			@else
				<div class="main center">
					暂时没有这类商品的数据！
				</div>

			@endif
		</div>
		
		
@endsection
	<!-- end danpin -->
