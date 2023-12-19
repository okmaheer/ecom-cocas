@php
$wrappings = get_wrapping_list();
@endphp
@if (!empty($wrappings))

<div class="productDirection dropdown-swatches-wrapper attribute-swatches-wrapper productWrapping" data-type="dropdown">
    <div class="attribute-name">Wrapping</div>
    <div class="attribute-values">
        <div class="dropdown-swatch">
           <ul class="wrapping_attr">
           		@foreach ($wrappings as $index => $wrapping)
           		<li>
                	<label for="product_wrapping_type_{{ $wrapping->id }}" title="{{ $wrapping->name }}">
                    	<input type="radio" name="product_wrapping_type" value="{{ $wrapping->name }}" id="product_wrapping_type_{{ $wrapping->id }}" @if($index == 0) checked @endif>
                        <div class="wrapping_image">
                        	<img src="{{ RvMedia::getImageUrl($wrapping->image, 'thumb') }}" alt="{{ $wrapping->name }}" />
                            <span>{{ $wrapping->name }}</span>
                        </div>
                    </label>
                </li>
                @endforeach
           </ul>
        </div>
    </div>
</div>
<style>
.productWrapping{margin-top:10px;}
.wrapping_attr{ padding:0; margin:0;}
.wrapping_attr li{ display:inline-block; padding:5px; width:115px;vertical-align: top;}
.wrapping_attr input{ float:left; width:25px;}
.wrapping_attr .wrapping_image{ float:left; width:80px;}
.wrapping_attr .wrapping_image img{width:100%;}
.wrapping_attr .wrapping_image span{font-size:13px;    display: block;}
.wrapping_attr label{cursor:pointer; }
</style>
<script>
$(document).ready(function(){
	
	$('#wrapping').val($('input[name="product_wrapping_type"]:checked').val());
	$('.wrapping_attr input').change(function(){
        var dataVal = $(this).val();
        $('#wrapping').val(dataVal);
    });
});
</script>
@endif