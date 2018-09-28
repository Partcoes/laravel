<div class="container-fluid">
	<div class="row">
		@foreach($data as $k => $v)
			<div class="col-lg-4">{{$v -> goods_name}}</div>
			<div class="col-lg-4">{{$v -> price}}</div>
			<div class="col-lg-4">{{$v -> sku}}</div>
		@endforeach
	</div>
</div>