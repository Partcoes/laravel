@extends('adminlte::page')
<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="http://adminlte.la998.com/plugins/iCheck/all.css">
<style>
    hr{
        border-bottom: 1px solid black !important;
    }
    .status_normal{
        color:green;
    }
    .status_stop{
        color:red;
    }
    #alone_head{
        margin-left: 5% !important;
        margin-bottom: 30px !important;
    }
    .tab{
        display: inline-block !important;
    }
    .nav-pills{
       border: 1px solid #ccc !important;
   }
    .btn-adn,.btn-info{
        width:35px !important;
        height: 35px !important;
    }
    .file-box,#select-src{
        padding: 4px 30px !important;
        height: 35px !important;
        line-height: 25px !important;
        color: #fafafa !important;
        position: relative !important;
        cursor: pointer !important;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        display: inline-block;
        *display: inline;
        *zoom: 1
    }
    .file-btn{
        position: absolute !important;
        font-size: 100px !important;
        right: 0 !important;
        top: 0 !important;
        opacity: 0 !important;
        filter: alpha(opacity=0) !important;
        cursor: pointer !important;
    }
</style>
@section('title', 'Dashboard')

@section('content_header')
    <h1>添加商品</h1>
    <hr/>
@stop

@section('content')
    <div>
        <ul class="nav nav-pills">
            <li class="tab active" tab="1"><a href="#">商品详情</a></li>
            <li class="tab" tab="2"><a href="#">商品简介</a></li>
            <li class="tab" tab="3"><a href="#">商品属性</a></li>
            <li class="tab" tab="4"><a href="#">商品相册</a></li>
        </ul>
    </div>
    <div style="margin-top: 15px">
        <form action="" method="post" enctype="multipart/form-data" multiple="true">
            @csrf
            <div id="detail" style="display: none">
                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <input type="text" name="goods_name" class="form-control" value=""
                           placeholder="商品名称">
                </div>
                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <input type="text" name="goods_number" class="form-control" value=""
                           placeholder="商品库存">
                </div>
                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <input type="text" name="shop_price" class="form-control" value=""
                           placeholder="商品价格">
                </div>
                <div class="form-group">
                    <input type="text" name="active_brief" class="form-control" value="5月19日，满1000减100"
                           placeholder="商品活动标语">
                </div>
                <div class="form-group">
                    <span class="file-box" style="background: #0056b3 !important;">
                        <input id="goods-img" onchange="test(this)" type="file" name="goods_img" class="file-btn">上传商品图片
                    </span>
                    <span id="select-src" style="width: 86.7%;border:1px solid #cccccc;"></span>
                </div>

                <div class="form-group">
                    <label>
                        <div class="icheckbox_minimal-blue disabled" aria-checked="false" aria-disabled="true" style="position: relative;"><input type="checkbox" name="is_hot" value="1" class="minimal" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                        热卖
                    </label>
                    <label style="margin-left: 10px">
                        <div class="icheckbox_minimal-blue disabled" aria-checked="false" aria-disabled="true" style="position: relative;"><input type="checkbox" name="is_up" value="1" class="minimal" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                        上架
                    </label>
                </div>
                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <select class="form-control" name="brand_id" id="">
                        <option value="">请选择品牌</option>
                        @foreach($brands as $k => $brand)
                            <option value="{{$brand -> brand_id}}">{{$brand -> brand_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="desc" class="cke_inner cke_reset" style="display: none">
                <textarea name="goods_desc" id="ckeditor" cols="30" rows="10"></textarea>
            </div>
            <div id="attr" style="display: none" style="width: 100% !important;">
                <select name="type_id" id="class-choose" class="form-control" style="width: 98.5% !important;margin-left: 0.8% !important;">
                    <option value="">请选择类型</option>
                    @foreach($classes as $k => $class)
                        <option value="{{$class -> typeof_id}}">{{$class -> typeof_name}}</option>
                    @endforeach
                </select>
                <div id="tbody">

                </div>
            </div>
            <div id="photos" style="display:none;margin-bottom: 20px">
                <div id="clone" style="margin-bottom: 20px !important;">
                    <span class="btn btn-adn" onclick="addSpec(this)">+</span>
                    <input type='text' name="photo_desc[]" style="width:33%;display: inline-block;" value="图片简介" class="form-control" placeholder="图片简介">
                    <input class="photo-src" type="file" name="photo_src[]" style="display: inline-block">
                    {{--<input type="text" placeholder="图片外部链接" value="www.baidu.com" class="form-control" name="photo_url[]" style="width:33%;display: inline-block">--}}

                </div>
            </div>
            <div>
                <button type="submit"
                        class="btn btn-primary btn-block btn-flat"
                >添加商品</button>
            </div>
        </form>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script src="/vendor/Adminlte/plugins/iCheck/icheck.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('ckeditor');
    </script>
    <script>
        $(function () {
            //初始化InputMask控件

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            })
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            })
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            })
        });

    </script>
    <script>
        $('.tab').click(function(){
            $('.tab').prop('class','tab');
            $(this).prop('class','tab active');
            var tab = $(this).attr('tab');
            if(tab == 1){
                show('#detail');
            }else if(tab ==2){
                show('#desc');
            }else if(tab ==3){
                show('#attr');
            }else if(tab == 4){
                show('#photos');
            }else{
                show('#detail');
            }
        })
        $(document).ready(function(){
            show('#detail');
        })
        function show(tab)
        {
            $('#detail').prop('style','display:none');
            $('#desc').prop('style','display:none');
            $('#attr').prop('style','display:none');
            $('#photos').prop('style','display:none;');
            $(tab).prop('style','display:block;margin-bottom:20px;');
        }

        // $('.btn-adn').click(function(){
        //     var len = $("input[type='file']").length;
        //     if(len < 3){
        //         $('#clone').find('.btn-adn').prop('class','btn btn-info');
        //         $('#clone').find('.btn-info').text('-');
        //         $('#clone').find('.btn-info').attr('onclick','removeDiv(this)');
        //         $('#clone').clone(true).insertBefore('#clone');
        //         $('#clone').find('.btn-info').prop('class','btn btn-adn');
        //         $('#clone').find('.btn-adn').text('+');
        //     }
        // })
        $('#class-choose').change(function(){
            var typeof_id = $(this).val();
            $.ajax({
                url:"{{url("goods/child")}}"+'/'+typeof_id,
                type:'get',
                success:function(msg){
                    $('#tbody').html(msg);
                }
            })
        })
        function addSpec(obj){
            var copycon = $(obj).parent().clone();
            //alert(copycon);
            var len = $(".photo-src").length;
            // console.log(len);return;
            if(len < 5){
                $(obj).parent().after(copycon);
                $(obj).parent().next().find('span').text('-');
                $(obj).parent().next().find('span').prop('class','btn btn-info');
                $(obj).parent().next().find('span').attr('onclick','lessSpec(this)');
            }

        }

        function addAttr(obj)
        {
            var copycon = $(obj).parents('tr').clone();
            //alert(copycon);
                $(obj).parents('tr').after(copycon);
                $(obj).parents('tr').next().find('span').text('-');
                $(obj).parents('tr').next().find('span').attr('onclick','lessAttr(this)');
        }
        function test(obj){
            var val = obj .value;
            var len = val.length;
            var position = val.lastIndexOf("\\");
            val = val.substring(position+1,len);
            var html = "<b style='color:black'>"+val+"</b>";
            $('#select-src').html(html);
        }
        function lessAttr(obj)
        {
            $(obj).parents('tr').remove();
        }
        /**
         * 删除行
         * @param {type} obj
         * @returns {undefined}
         */
        function lessSpec(obj){
            $(obj).parent().remove();
        }
        function removeDiv(obj)
        {
            $(obj).parent('#clone').remove();
        }

    </script>
    <script> console.log('Hi!'); </script>
@stop