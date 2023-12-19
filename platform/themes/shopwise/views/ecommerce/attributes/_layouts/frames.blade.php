@php
$frames = get_frame_list();
@endphp
@if (!empty($frames))

<div class="productDirection dropdown-swatches-wrapper attribute-swatches-wrapper productFrame" data-type="dropdown">
    <div class="attribute-name">Frame</div>
    <div class="attribute-values">
        <div class="dropdown-swatch">
           <ul class="frame_attr">
           		@foreach ($frames as $index => $frame)
           		<li>
                	<label for="product_frame_type_{{ $frame->id }}" title="{{ $frame->name }}">
                    	<input type="radio" name="product_frame_type" value="{{ $frame->name }}" data-price="{{ $frame->price }}" id="product_frame_type_{{ $frame->id }}" @if($index == 0) checked @endif>
                        <div class="frame_image">
                        	<img src="{{ RvMedia::getImageUrl($frame->image, 'thumb') }}" alt="{{ $frame->name }}" />
                            <span>{{ $frame->name }}</span>
                        </div>
                    </label>
                </li>
                @endforeach
           </ul>
        </div>
    </div>
</div>
<style>
.productFrame{margin-top:10px;}
.frame_attr{ padding:0; margin:0;}
.frame_attr li{ display:inline-block; padding:5px; width:115px;vertical-align: top;}
.frame_attr input{ float:left; width:25px;}
.frame_attr .frame_image{ float:left; width:80px;}
.frame_attr .frame_image img{width:100%;}
.frame_attr .frame_image span{font-size:13px;    display: block;}
.frame_attr label{cursor:pointer; }
</style>
<script>
$(document).ready(function(){
	$('#frame').val($('input[name="product_frame_type"]:checked').val());
	$('.frame_attr input').change(function(){
        var dataVal = $(this).val();
        $('#frame').val(dataVal);
		updatePrice();
    });
});
</script>
@endif