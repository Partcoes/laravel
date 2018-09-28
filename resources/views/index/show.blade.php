@extends('common.template')
	<!-- start header -->
		@section('content')
	<!--end header -->

<!-- start banner_x -->
		<div class="banner_x center">
			<a href="{{url('Index/index')}}" target="_blank"><div class="logo fl"></div></a>
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
			<div class="main center">
				<div class="mingxing fl mb20" style="border:2px solid #fff;width:230px;cursor:pointer;" onmouseout="this.style.border='2px solid #fff'" onmousemove="this.style.border='2px solid red'">
					<div class="sub_mingxing"><a href="{{url('Index/getdetailbyid/id/1')}}" target="_blank"><img src="liebiao_xiaomi6.jpg" alt=""></a></div>
					<div class="pinpai"><a href="./xiangqing.html" target="_blank">小米6</a></div>
					<div class="youhui">5.16早10点开售</div>
					<div class="jiage">2499.00元</div>
				</div>
				<div class="mingxing fl mb20" style="border:2px solid #fff;width:230px;cursor:pointer;" onmouseout="this.style.border='2px solid #fff'" onmousemove="this.style.border='2px solid red'">
					<div class="sub_mingxing"><a href=""><img src="liebiao_xiaomi5c.jpg" alt=""></a></div>
					<div class="pinpai"><a href="">小米手机5c</a></div>
					<div class="youhui">搭载澎湃S1 八核高性能处理器</div>
					<div class="jiage">1499.00元</div>
				</div>
				<div class="mingxing fl mb20" style="border:2px solid #fff;width:230px;cursor:pointer;" onmouseout="this.style.border='2px solid #fff'" onmousemove="this.style.border='2px solid red'">
					<div class="sub_mingxing"><a href=""><img src="liebiao_xiaomint2.jpg" alt=""></a></div>
					<div class="pinpai"><a href="">小米Note 2</a></div>
					<div class="youhui">5月9日-20日 小米Note 2 享花呗12期分期免息</div>
					<div class="jiage">2799.00元</div>
				</div>
				<div class="mingxing fl mb20" style="border:2px solid #fff;width:230px;cursor:pointer;" onmouseout="this.style.border='2px solid #fff'" onmousemove="this.style.border='2px solid red'">
					<div class="sub_mingxing"><a href=""><img src="liebiao_xiaomimix.jpg" alt=""></a></div>
					<div class="pinpai"><a href="">小米MIX</a></div>
					<div class="youhui">5月9日-20日小米MIX 享花呗12期分期免息</div>
					<div class="jiage">3499.00元</div>
				</div>
				<div class="mingxing fl mb20" style="border:2px solid #fff;width:230px;cursor:pointer;" onmouseout="this.style.border='2px solid #fff'" onmousemove="this.style.border='2px solid red'">
					<div class="sub_mingxing"><a href=""><img src="liebiao_xiaomi5s.jpg" alt=""></a></div>
					<div class="pinpai"><a href="">小米5s</a></div>
					<div class="youhui">“暗夜之眼”超感光相机 / 无孔式超声波</div>
					<div class="jiage">1999.00元</div>
				</div>

				<div class="clear"></div>
			</div>
			<div class="main center mb20">
				<div class="mingxing fl mb20" style="border:2px solid #fff;width:230px;cursor:pointer;" onmouseout="this.style.border='2px solid #fff'" onmousemove="this.style.border='2px solid red'">
					<div class="sub_mingxing"><a href=""><img src="liebiao_xiaomi5.jpg" alt=""></a></div>
					<div class="pinpai"><a href="">小米手机5</a></div>
					<div class="youhui">骁龙820处理器 / UFS 2.0 闪存</div>
					<div class="jiage">1799.00元</div>
				</div>
				<div class="mingxing fl mb20" style="border:2px solid #fff;width:230px;cursor:pointer;" onmouseout="this.style.border='2px solid #fff'" onmousemove="this.style.border='2px solid red'">
					<div class="sub_mingxing"><a href=""><img src="liebiao_hongmin4.jpg" alt=""></a></div>
					<div class="pinpai"><a href="">红米Note 4</a></div>
					<div class="youhui">十核旗舰处理器 / 全金属一体化机身 </div>
					<div class="jiage">1399.00元</div>
				</div>
				<div class="mingxing fl mb20" style="border:2px solid #fff;width:230px;cursor:pointer;" onmouseout="this.style.border='2px solid #fff'" onmousemove="this.style.border='2px solid red'">
					<div class="sub_mingxing"><a href=""><img src="pinpai3.png" alt=""></a></div>
					<div class="pinpai"><a href="">小米手机5 64GB</a></div>
					<div class="youhui">5月9日-10日，下单立减100元</div>
					<div class="jiage">1799元</div>
				</div>
				<div class="mingxing fl mb20" style="border:2px solid #fff;width:230px;cursor:pointer;" onmouseout="this.style.border='2px solid #fff'" onmousemove="this.style.border='2px solid red'">
					<div class="sub_mingxing"><a href=""><img src="liebiao_hongmin42.jpg" alt=""></a></div>
					<div class="pinpai"><a href="">红米4</a></div>
					<div class="youhui">2.5D 玻璃，金属一体化机身</div>
					<div class="jiage">999.00元</div>
				</div>
				<div class="mingxing fl mb20" style="border:2px solid #fff;width:230px;cursor:pointer;" onmouseout="this.style.border='2px solid #fff'" onmousemove="this.style.border='2px solid red'">
					<div class="sub_mingxing"><a href=""><img src="liebiao_hongmin4x.jpg" alt=""></a></div>
					<div class="pinpai"><a href="">红米Note 4X 全网通版</a></div>
					<div class="youhui">多彩金属 / 4100mAh 超长续航</div>
					<div class="jiage">1299.00元</div>
				</div>
				
				<div class="clear"></div>
			</div>
		</div>
		
		
@endsection
	<!-- end danpin -->
