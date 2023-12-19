<div class="productDirection dropdown-swatches-wrapper attribute-swatches-wrapper" data-type="dropdown">
    <div class="attribute-name">Size</div>
    <div class="attribute-values productSizes">
        <div class="dropdown-swatch">
        	@php
            $baseWidth = floatval($product->wide);
            $baseHeight = floatval($product->height);
            
            $basePrice = $product->front_sale_price_with_taxes;
            $price = number_format(floatval($baseWidth)*floatval($baseHeight)*floatval($basePrice), 2, '.', '');  
            $increasePercenatge = setting('product_hw_percentage');
            $heading = ['', 'Small', 'Medium', 'Large', 'Extra large', 'Double extra large'];
                            
            $sizeArr[0]['price'] = round($price);
            $sizeArr[0]['data'] = 'Base: '.$baseWidth.' cm(W) x '.$baseHeight.' cm(H)';
            $sizeArr[0]['width'] = $baseWidth;
            $sizeArr[0]['height'] = $baseHeight;
            
            for($i = 1; $i <= 5; $i++){
            	$baseWidth =  number_format($baseWidth+($baseWidth/100)*$increasePercenatge,2);
                $baseHeight = number_format($baseHeight+($baseHeight/100)*$increasePercenatge,2); 
                $price = number_format(floatval($baseWidth)*floatval($baseHeight)*floatval($basePrice), 2, '.', '');               
                $sizeArr[$i]['price'] = round($price);
            	$sizeArr[$i]['data'] = $heading[$i].': '.$baseWidth.' cm(W) x '.$baseHeight.' cm(H)';
                $sizeArr[$i]['width'] = $baseWidth;
           		$sizeArr[$i]['height'] = $baseHeight;
            }
            
            @endphp
            <label> 
            <select type="text" class="form-control attr_select" id="product_image_sizes">
            	@foreach($sizeArr as $size)
                	<option value="{{ $size['data'] }}" price-data="{{ $size['price'] }}" data-width="{{ $size['width'] }}" data-height="{{ $size['height'] }}">{{ $size['data'] }}</option>              
                @endforeach
            </select> 
            </label>
        </div>
    </div> 
</div>

<script>
$(document).ready(function(){
	var priceData = $('#product_image_sizes').find('option:selected').attr('price-data');
	var sizeData = $('#product_image_sizes').find('option:selected').val();
	$('.product_price .product-sale-price-text').html('₹'+priceData);
	$('#product_sizes').val(sizeData);
	
	$('#product_image_sizes').change(function(){
		var sizeData = $(this).find('option:selected').val();
		$('#product_sizes').val(sizeData);
		updatePrice();
    });
});
</script>