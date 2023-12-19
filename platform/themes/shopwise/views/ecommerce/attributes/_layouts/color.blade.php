@php
$colors = array();
if($product->product_colors != ''){
    $colorsData = $product->product_colors;
    if(!empty($colorsData)){
        $colors = json_decode((string)$colorsData, true);
        if (is_array($colors)) {
            $colors = array_filter($colors);
        }
    }
}
@endphp
@if(count($colors) > 1)
 <div class="visual-swatches-wrapper attribute-swatches-wrappers form-group product__attribute product__color" data-type="visual">
  <label class="attribute-name">Color</label>
  <div class="attribute-values">
            <ul class="visual-swatch color-swatch attribute-swatch">
      @foreach($colors as $key => $attribute)
      @php
      	$colorArr = explode("||", $attribute);
        $slug = strtolower(trim($colorArr[0]));
        $slug = str_replace(' ','-',$slug);
        $colorArr['slug'] = $slug;

      @endphp
      <li data-slug="{{ $colorArr['slug'] }}"
                    data-id="{{ $colorArr[0] }}"
                    class="attribute-swatch-item"
                    title="{{ $colorArr[0] }}">
                <div class="custom-radio">
          <label>
                    <input class="form-control product-filter-item"
                                type="radio"
                                name="attribute_colors"
                                value="{{ $colorArr[0] }}"
                                {{-- {{ $loop->index == 0 ? 'checked' : '' }} --}}
                                > <span class="colorBoxs" style="{{ 'background-color: ' . $colorArr[1] . ';' }}"></span> </label>
        </div>
              </li>
      @endforeach
    </ul>
  </div>
</div>
@endif
<style>

.colorBoxs:before{border: 2px solid #DDD;
    border-radius: 50%;
    bottom: -4px;
    content: "";
    display: block;
    left: -4px;
    position: absolute;
    right: -4px;
    top: -4px;}
	.product__color .color-swatch li {
    margin-top: 12px;
    margin-right: 8px;
</style>
