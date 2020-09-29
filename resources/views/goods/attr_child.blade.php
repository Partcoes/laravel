<table class="table" id="attrTable">
    @foreach($attrInfo as $k => $attr)
        @if($attr['attr_type'] == 2)
            <tr>
                <td style="width:10% !important;">
                    <span class="btn btn-twitter" onclick="addAttr(this)">+</span>　{{$attr['attr_name']}}
                </td>
                <td>
                    <select class="form-control" style="width: 46.8% !important;display:inline-block !important;" name="attr_value_list[{{$attr['attr_id']}}][]">
                        <option value="">请选择...</option>
                        @foreach($attr['attr_value'] as $k => $attr_val )
                        <option value="{{$attr_val}}">{{$attr_val}}</option>
                        @endforeach
                    </select>　价格　<input style="width: 46.8%;display:inline-block !important;" class="form-control" type="text" name="attr_price_list[{{$attr['attr_id']}}][]" value="" maxlength="10">
                </td>
            </tr>
        @elseif($attr['attr_type'] == 1)
            <tr>
                <td colspan="2">
                    <input type="hidden" name="attr_id_list[{{$attr['attr_id']}}]" value="6">
                    <input  class="form-control" name="attr_value_list[]" placeholder="{{$attr['attr_name']}}" type="text" value="" size="40">
                    <input type="hidden" name="attr_price_list[{{$attr['attr_id']}}][]" value="0">
                </td>
            </tr>
        @endif
    @endforeach
</table>