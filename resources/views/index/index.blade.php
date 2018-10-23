<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>小米商城</title>
		<link rel="stylesheet" type="text/css" href="{{URL::asset('css/user/style.css')}}">
		<base href="{{URL::asset('images/user')}}"></base>
	</head>
	<body>
	<!-- start header -->
		@include('common.header',['message'=>'该模板不存在！'])
	<!--end header -->

<!-- start banner_x -->
		<div class="banner_x center">
			<a href="{{url('Index/index')}}" target="_blank"><div class="logo fl"></div></a>
			<a href=""><div class="ad_top fl"></div></a>
			<div class="nav fl">
				<ul>
					<li><a href="{{url('index/show')}}" target="_blank">小米手机</a></li>
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
		<div class="banner_y center">
			<div class="nav">				
				<ul>
					@if($type)
						@foreach($type as $key=>$type)
					<li>
						<a href="{{url('index/show',['id'=>$type['type_id']])}}">{{$type['type_name']}}</a>
						<div class="pop">
							<div class="left fl">
								@if(isset($type['son']))
								@foreach($type['son'] as $k=>$son)

									@if( isset($son['reid']) &&$son['reid'] < 6)
								<div>
									<div class="xuangou_left fl">
										<a href="">
											<div class="img fl"><img  style="width:40px;height:40px;" src="{{$son['icon']}}" alt=""></div>
											<span class="fl">{{mb_substr($son['type_name'],0,11)}}</span>
											<div class="clear"></div>
										</a>
									</div>
									<div class="xuangou_right fr"><a href="">选购</a></div>
									<div class="clear"></div>
								</div>
										@endif
									@endforeach
								@endif
							</div>
							<div class="ctn fl">
								@if(isset($type['son']))
									@foreach($type['son'] as $k=>$son)

										@if( isset($son['reid']) && $son['reid'] >= 6 && $son['reid'] < 12)
								<div>
									<div class="xuangou_left fl">
										<a href="">
											<div class="img fl"><img style="width:40px;height:40px;" src="{{$son['icon']}}" alt=""></div>
											<span class="fl">{{mb_substr($son['type_name'],0,15)}}</span>
											<div class="clear"></div>
										</a>
									</div>
									<div class="xuangou_right fr"><a href="">选购</a></div>
									<div class="clear"></div>
								</div>
										@endif
									@endforeach
								@endif
							</div>
							<div class="right fl">
								@if(isset($type['son']))
									@foreach($type['son'] as $k=>$son)

										@if( isset($son['reid']) && $son['reid'] >= 12 && $son['reid'] < 18)
								<div>
									<div class="xuangou_left fl">
										<a href="">
											<div class="img fl"><img  style="width:40px;height:40px;" src="{{$son['icon']}}" alt=""></div>
											<span class="fl">{{mb_substr($son['type_name'],0,15)}}</span>
											<div class="clear"></div>
										</a>
									</div>
									<!-- <div class="xuangou_right fr"><a href="">选购</a></div> -->
									<div class="clear"></div>
								</div>
										@endif
									@endforeach
								@endif
							</div>
							<div class="clear"></div>
						</div>
					</li>
						@endforeach
					@endif
				</ul>
			</div>
		
		</div>	
	@if($advertise)
		<div class="sub_banner center">
			<div class="sidebar fl">
				@foreach($advertise as $k => $advertisement)
					@if($advertisement -> advertise_type == 0)

						<div class="fl"><a href="{{$advertisement->advertise_url}}"><img src="{{$advertisement->advertise_img}}"></a></div>
					@endif
				@endforeach
				<div class="clear"></div>
			</div>
			@foreach($advertise as $k => $advertisement)
				@if($advertisement -> advertise_type == 1)
					<div class="datu fl"><a href="{{$advertisement -> advertise_url}}"><img src="{{$advertisement -> advertise_img}}" alt=""></a></div>
				@endif
			@endforeach

			<div class="clear"></div>


		</div>
	@endif
	<!-- end banner -->
	<div class="tlinks">Collect from <a href="http://www.cssmoban.com/" >企业网站模板</a></div>

	<!-- start danpin -->
		<div class="danpin center">
			
			<div class="biaoti center">小米明星单品</div>
			<div class="main center">
				@if(isset($goods))
					@foreach($goods as $k => $topForGood)
					<div class="mingxing fl">
						<div class="sub_mingxing"><a href=""><img src="{{$topForGood -> goods_img}}" alt=""></a></div>
						<div class="pinpai"><a href="">{{$topForGood -> goods_name}}</a></div>
						<div class="youhui">{{$topForGood -> active_brief}}</div>
						<div class="jiage">{{$topForGood -> shop_price}}元起</div>
					</div>
					@endforeach
				@endif
				<div class="clear"></div>
			</div>
		</div>
		<div class="peijian w">
			<div class="biaoti center">配件</div>
			<div class="main center">
				<div class="content">
					<div class="remen fl"><a href=""><img src="user/peijian1.jpg"></a>
					</div>
					<div class="remen fl">
						<div class="xinpin"><span>新品</span></div>
						<div class="tu"><a href=""><img src="user/peijian2.jpg"></a></div>
						<div class="miaoshu"><a href="">小米6 硅胶保护套</a></div>
						<div class="jiage">49元</div>
						<div class="pingjia">372人评价</div>
						<div class="piao">
							<a href="">
								<span>发货速度很快！很配小米6！</span>
								<span>来至于mi狼牙的评价</span>
							</a>
						</div>
					</div>
					<div class="remen fl">
						<div class="xinpin"><span style="background:#fff"></span></div>
						<div class="tu"><a href=""><img src="user/peijian3.jpg"></a></div>
						<div class="miaoshu"><a href="">小米手机4c 小米4c 智能</a></div>
						<div class="jiage">29元</div>
						<div class="pingjia">372人评价</div>
					</div>
					<div class="remen fl">
						<div class="xinpin"><span style="background:red">享6折</span></div>
						<div class="tu"><a href=""><img src="user/peijian4.jpg"></a></div>
						<div class="miaoshu"><a href="">红米NOTE 4X 红米note4X</a></div>
						<div class="jiage">19元</div>
						<div class="pingjia">372人评价</div>
						<div class="piao">
							<a href="">
								<span>发货速度很快！很配小米6！</span>
								<span>来至于mi狼牙的评价</span>
							</a>
						</div>
					</div>
					<div class="remen fl">
						<div class="xinpin"><span style="background:#fff"></span></div>
						<div class="tu"><a href=""><img src="user/peijian5.jpg"></a></div>
						<div class="miaoshu"><a href="">小米支架式自拍杆</a></div>
						<div class="jiage">89元</div>
						<div class="pingjia">372人评价</div>
						<div class="piao">
							<a href="">
								<span>发货速度很快！很配小米6！</span>
								<span>来至于mi狼牙的评价</span>
							</a>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="content">
					<div class="remen fl"><a href=""><img src="user/peijian6.png"></a>
					</div>
					<div class="remen fl">
						<div class="xinpin"><span style="background:#fff"></span></div>
						<div class="tu"><a href=""><img src="user/peijian7.jpg"></a></div>
						<div class="miaoshu"><a href="">小米指环支架</a></div>
						<div class="jiage">19元</div>
						<div class="pingjia">372人评价</div>
						<div class="piao">
							<a href="">
								<span>发货速度很快！很配小米6！</span>
								<span>来至于mi狼牙的评价</span>
							</a>
						</div>
					</div>
					<div class="remen fl">
						<div class="xinpin"><span style="background:#fff"></span></div>
						<div class="tu"><a href=""><img src="user/peijian8.jpg"></a></div>
						<div class="miaoshu"><a href="">米家随身风扇</a></div>
						<div class="jiage">19.9元</div>
						<div class="pingjia">372人评价</div>
					</div>
					<div class="remen fl">
						<div class="xinpin"><span style="background:#fff"></span></div>
						<div class="tu"><a href=""><img src="user/peijian9.jpg"></a></div>
						<div class="miaoshu"><a href="">红米4X 高透软胶保护套</a></div>
						<div class="jiage">59元</div>
						<div class="pingjia">775人评价</div>
					</div>
					<div class="remenlast fr">
						<div class="hongmi"><a href=""><img src="user/hongmin4.png" alt=""></a></div>
						<div class="liulangengduo"><a href=""><img src="user/liulangengduo.png" alt=""></a></div>
					</div>
					<div class="clear"></div>
				</div>				
			</div>
		</div>
		@include('common.footer',['message'=>'该模板不存在！'])
	</body>
</html>