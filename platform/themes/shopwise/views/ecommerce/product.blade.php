@php
Theme::asset()->remove('app-js');
Theme::set('pageName', $product->name);
@endphp

@php $category_name=''; $categoryArray = array(); @endphp
@foreach ($product->categories()->get() as $category)
@php $category_name = $category->name; $categoryArray[] = $category->name; @endphp
@endforeach

<style>
    #width_wall_mural_inpt::-webkit-outer-spin-button,
#width_wall_mural_inpt::-webkit-inner-spin-button,
#height_wall_mural_inpt::-webkit-outer-spin-button,
#height_wall_mural_inpt::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
#width_wall_mural_inpt,#height_wall_mural_inpt {
  -moz-appearance: textfield;
}
</style>

<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-md-5 mb-4 mb-md-0">
        <div class="product-image">
          <div class="product_img_box">
          <div style="position:relative">
            <img id="product_img" src="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}" @if( $category_name !='Wall Mural') data-zoom-enable="true" data-zoom-image="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}" @endif alt="{{ $product->name }}" />
             <a href="#" class="product_img_zoom" title="Zoom"> <span class="linearicons-zoom-in"></span> </a> </div></div>
          <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false"> @php
            $transimg = ''
            @endphp
            @foreach ($productImages as $key => $img)
            <div class="item @if(count($productImages)==($key+1)) trans-img @endif"> <a href="#" class="product_gallery_item @if ($loop->first) active @endif" data-image="{{ RvMedia::getImageUrl($img) }}" data-zoom-image="{{ RvMedia::getImageUrl($img) }}"> <img src="{{ RvMedia::getImageUrl($img, 'thumb') }}" alt="{{ $product->name }}" @if(count($productImages)==($key+1)) style="background-color: #000000;" @endif/> </a> @if ($key > 0)
              @php
              $transimg = RvMedia::getImageUrl($img, '')
              @endphp
              @endif </div>
            @endforeach </div>
        </div>
      </div>
      <input type="hidden" id="getTransparantIMG" value="{{$transimg}}">
      <div class="col-lg-7 col-md-7">
        <div class="pr_detail">
          <div class="product_description">
            <h4 class="product_title"><a href="{{ $product->url }}">{{ $product->name }}</a></h4>
            <div class="product_desc"> {!! clean($product->description) !!}
              <p>{{ __('SKU') }}: <span id="product-sku">{{ $product->sku }}</span></p>
            </div>
            <div class="product_price"> <span class="price product-sale-price-text">{{ format_price($product->front_sale_price_with_taxes) }}</span> <del class="product-price-text" @if ($product->front_sale_price == $product->price) style="display: none" @endif>{{ format_price($product->price_with_taxes) }}</del>
              <div class="on_sale" @if ($product->front_sale_price == $product->price) style="display: none" @endif> <span class="on_sale_percentage_text">{{ get_sale_percentage($product->price, $product->front_sale_price) }}</span> <span>{{ __('Off') }}</span> </div>
            </div>
            @if (EcommerceHelper::isReviewEnabled())
            @if ($product->reviews_count > 0)
            <div class="rating_wrap">
              <div class="rating">
                <div class="product_rate" style="width: {{ $product->reviews_avg * 20 }}%"></div>
              </div>
              <span class="rating_num">({{ $product->reviews_count }})</span> </div>
            @endif
            @endif
            <div class="clearfix"></div>
            <hr />

            <!-- For Single Custom Print -->

            @if($category_name=='Single Canvas Print')
            <div>
              <h5 class="product_title">Step 1</h5>
              <button class="btn btn-fill-out btn-addtocart" type="button"> <i class="icon-basket-loaded"></i> Upload Image </button>
            </div>
            <br>
            <h5 class="product_title">Step 2</h5>
            @endif
            <!-- Single Custom Print end -->

            @if( $product->height > 0 && $product->wide > 0)
            {!! render_product_swatches($product, [
            'view' => Theme::getThemeNamespace() . '::views.ecommerce.attributes._layouts.custom_sizes'
            ]) !!}
            @endif

            @if ($product->variations()->count() > 0)
            <div class="pr_switch_wrap"> {!! render_product_swatches($product, [
              'selected' => $selectedAttrs,
              'view' => Theme::getThemeNamespace() . '::views.ecommerce.attributes.swatches-renderer'
              ]) !!} </div>
            @else
            @if($product->product_colors != '')
            <div class="product-attributes" data-target="{{ route('public.web.get-variation-by-attributes', ['id' => $product->id]) }}"> @include(Theme::getThemeNamespace(). '::views.ecommerce.attributes._layouts.color') </div>
            @endif
            @endif

            @if( in_array('Wall Mural',$categoryArray))
            	@include(Theme::getThemeNamespace() . '::views/ecommerce/wall_mural_attributes')
                 @if( $product->is_materials == 1)
                   @include(Theme::getThemeNamespace() . '::views/ecommerce.attributes._layouts.materials')
                 @endif
            @endif

            @if( $product->is_direction == 1)
            @include(Theme::getThemeNamespace() . '::views/ecommerce/direction_attributes')
            @endif

            @if( $product->height > 0 && $product->wide > 0 && !in_array('Wall Mural',$categoryArray))

                @if( $product->is_materials == 1)
                @include(Theme::getThemeNamespace() . '::views/ecommerce.attributes._layouts.materials')
                @endif

                @if( $product->is_frames == 1)
                @include(Theme::getThemeNamespace() . '::views/ecommerce.attributes._layouts.frames')
                @endif

                @if( $product->is_wrappings == 1)
                @include(Theme::getThemeNamespace() . '::views/ecommerce.attributes._layouts.wrappings')
                @endif

            @endif

             @if( in_array('Wall Mural',$categoryArray))
                 @if( $product->is_materials == 1)
                   @include(Theme::getThemeNamespace() . '::views/ecommerce.attributes._layouts.cover_entire_wall')
                 @endif
            @endif

            <hr>
            <div class="cart_extra">
              <form class="add-to-cart-form" method="POST" action="{{ route('public.cart.add-to-cart') }}" enctype="multipart/form-data" accept-encoding="br gzip deflate">
                @csrf

                 @if( in_array('Wall Mural',$categoryArray))
                <input type="hidden" name="image_position" id="image_position" value="" />
                <input type="hidden" name="width_wall_mural" id="width_wall_mural" value="" />
                <input type="hidden" name="height_wall_mural" id="height_wall_mural" value="" />
                <input type="hidden" name="customCropImage" id="customCropImage" value="">
                <input type="hidden" name="material_wall_mural" id="material_wall_mural" value="">
                <input type="hidden" name="cover_entire_wall" id="cover_entire_wall" value="">
                <input type="hidden" name="color_effect" id="color_effect" value="">

                @endif
                {{-- @if($category_name =='Textures')
                <input type="hidden" name="customCropImage_a" id="customCropImage" value="">
                @endif --}}
                @php
                    $wall_sticker_parent_id = 65;
                    $is_wall_sticker_category = $product->categories->where('id',$wall_sticker_parent_id)->count() > 0;
                    $is_wall_sticker_child_category = $product->categories->where('parent_id',$wall_sticker_parent_id)->count() > 0;
                @endphp
                @if($is_wall_sticker_category || $is_wall_sticker_child_category)
                <input type="hidden" name="productcolor" id="productcolor" value="" />
                @endif
                <input type="hidden" name="image_direction" id="image_direction"/>
                <input type="hidden" name="product_category" value="{{$product->categories->pluck('id')}}">
                <input type="hidden" name="wrapping" id="wrapping" value="" />
                <input type="hidden" name="frame" id="frame" value="" />
                <input type="hidden" name="material" id="material" value="" />
                <input type="hidden" name="product_sizes" id="product_sizes" value="" />
                {!! apply_filters(ECOMMERCE_PRODUCT_DETAIL_EXTRA_HTML, null) !!}
                <input type="hidden" name="id" id="hidden-product-id" value="{{ ($product->is_variation || !$product->defaultVariation->product_id) ? $product->id : $product->defaultVariation->product_id }}" />
                @if (EcommerceHelper::isCartEnabled())
                <div class="cart-product-quantity">
                  <div class="quantity float-left">
                    <input type="button" value="-" class="minus">
                    <input type="text" name="qty" value="1" title="{{ __('Qty') }}" class="qty" size="4">
                    <input type="button" value="+" class="plus">
                  </div>
                  &nbsp;
                  <div class="float-right number-items-available" style="@if (!$product->isOutOfStock()) display: none; @endif line-height: 45px;"> @if ($product->isOutOfStock()) <span class="text-danger">({{ __('Out of stock') }})</span> @endif </div>
                </div>
                @endif
                <div class="cart_btn"> @if (EcommerceHelper::isCartEnabled())
                    @if($category_name =='Wall Mural')
                    <button class="btn btn-fill-out checkVaidation @if ($product->isOutOfStock()) btn-disabled @endif" type="{{ $category_name =='Wall Mural'?'button':'submit'}}" @if ($product->isOutOfStock()) disabled @endif><i class="icon-basket-loaded"></i> {{ __('Add to cart') }}</button>
                    @endif
                    {{-- <button class="checkVaidation" id="button"> Crop </button> --}}
                    <button class="btn btn-fill-out btn-addtocart {{ $category_name =='Textures'?'checkVaidation':''}}{{ $category_name =='Wall Mural'?'btnAddtoCart':''}}  @if ($product->isOutOfStock()) btn-disabled @endif" type="submit" @if ($product->isOutOfStock()) disabled @endif  @if ($category_name =='Wall Mural') style="visibility:hidden; height:0; width:0;margin: 0; padding: 0;" @endif><i class="icon-basket-loaded"></i> {{ __('Add to cart') }}</button>

                  @endif
                  @if (EcommerceHelper::isQuickBuyButtonEnabled())
                  &nbsp;
                  @if(in_array('Wall Mural',$product->categories()->pluck('name')->toArray()) )
                  <button class="btn btn-dark btn-addtocart checkQuickBuy @if ($product->isOutOfStock()) btn-disabled @endif" type="{{ in_array('Wall Mural',$product->categories()->pluck('name')->toArray()) ?'button':'submit'}}" @if ($product->isOutOfStock()) disabled @endif name="checkout">{{ __('Quick Buy') }}</button>
                  @endif
                  <button class="btn btn-dark btn-addtocart {{ in_array('Textures',$product->categories()->pluck('name')->toArray()) ?'checkQuickBuy':''}} {{ in_array('Wall Mural',$product->categories()->pluck('name')->toArray()) ?'btnQuickCheckout':''}}   @if ($product->isOutOfStock()) btn-disabled @endif" type="submit" @if ($product->isOutOfStock()) disabled @endif name="checkout" @if (in_array('Wall Mural',$product->categories()->pluck('name')->toArray()) ) style="visibility:hidden; height:0; width:0;margin: 0; padding: 0;" @endif>{{ __('Quick Buy') }}</button>
                  @endif
                  <?php /*?><a class="add_compare js-add-to-compare-button" data-url="{{ route('public.compare.add', $product->id) }}" href="#"><i class="icon-shuffle"></i></a><?php */?>
                  <a class="add_wishlist js-add-to-wishlist-button" href="#" data-url="{{ route('public.wishlist.add', $product->id) }}"><i class="icon-heart"></i></a> </div>
                <br>
                <div class="success-message text-success" style="display: none;"> <span></span> </div>
                <div class="error-message text-danger" style="display: none;"> <span></span> </div>
              </form>
            </div>
            <hr />
            <ul class="product-meta" style="display:none;">
              <?php /*?><li>{{ __('SKU') }}: <span id="product-sku">{{ $product->sku }}</span></li><?php */?>
              <li>{{ __('Category') }}:
                @foreach ($product->categories()->get() as $category) <a href="{{ $category->url }}">{{ $category->name }}</a>@if (!$loop->last),@endif
                @endforeach </li>
            </ul>
            <div class="product-tags"> @if (!$product->tags->isEmpty())
              <p>{{ __('Tags') }}:
                @foreach ($product->tags as $tag) <a href="{{ $tag->url }}" rel="tag">{{ $tag->name }}</a>@if (!$loop->last),@endif
                @endforeach </p>
              @endif </div>
            <div class="product_share"> <span>{{ __('Share') }}:</span>
              <ul class="social_icons">
                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($product->url) }}&title={{ rawurldecode($product->description) }}" target="_blank" title="{{ __('Share on Facebook') }}"><i class="ion-social-facebook"></i></a></li>
                <li><a href="https://twitter.com/intent/tweet?url={{ urlencode($product->url) }}&text={{ rawurldecode($product->description) }}" target="_blank" title="{{ __('Share on Twitter') }}"><i class="ion-social-twitter"></i></a></li>
                <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($product->url) }}&summary={{ rawurldecode($product->description) }}&source=Linkedin" title="{{ __('Share on Linkedin') }}" target="_blank"><i class="ion-social-linkedin"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="medium_divider clearfix"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="tab-style3">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"> <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">{{ __('Description') }}</a> </li>
            <li class="nav-item"> <a class="nav-link" id="apply-tab" data-toggle="tab" href="#apply" role="tab" aria-controls="apply" aria-selected="true">{{ __('How to Apply') }}</a> </li>
            <li class="nav-item"> <a class="nav-link" id="warranty-tab" data-toggle="tab" href="#warranty" role="tab" aria-controls="warranty" aria-selected="true">{{ __('Warranty & Returns') }}</a> </li>
            @if (EcommerceHelper::isReviewEnabled())
            <li class="nav-item"> <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">{{ __('Reviews') }} ({{ $product->reviews_count }})</a> </li>
            @endif
          </ul>
          <div class="tab-content shop_info_tab">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
              <div id="app"> {!! clean($product->content) !!} </div>
              @if (theme_option('facebook_comment_enabled_in_product', 'yes') == 'yes') <br />
              {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, Theme::partial('comments')) !!}
              @endif
              <p style="margin-bottom:0px;"><strong>Application:</strong> Can be applied to any flat surfaces such as painted walls or ceiling, wallpaper, cupboard, furniture, glass, metal, even in the bathroom.</p>
              <p><strong>Features:</strong> Finest quality film, eco-friendly, removable, repositionable, can be wiped clean, easy to apply. Colours of the product may slightly vary from the photo(s) due to monitor settings and light reflections.</p>
            </div>
            <div class="tab-pane fade" id="apply" role="tabpanel" aria-labelledby="apply-tab">
              <p><strong>HOW TO  APPLY WALL STICKERS</strong><br />
OPEN &amp; Download PDF File / Visit -&nbsp;<a href="{{ url('/installation-files/wall-sticker-installation.pdf'); }}" target="_blank">Wall Sticker Installation </a></p>
              <p><strong>HOW TO  APPLY WALL MURALS</strong><br />
                OPEN &amp; Download PDF File / Visit -&nbsp;<a href="{{ url('/installation-files/wall-mural-paste-required-installation.pdf'); }}" target="_blank">Wall Mural Paste Required  Installation</a> <br />
                OPEN  &amp; Download PDF File / Visit -&nbsp;<a href="{{ url('/installation-files/wall-mural-peel-stick-installation.pdf'); }}" target="_blank">Wall Mural Peel Stick  Installation</a></p>
<strong>HOW  TO INSTALL WALL DISPLAY</strong><br />
OPEN &amp; Download PDF File / Visit -&nbsp;<a href="{{ url('/installation-files/wall-art-canvas-installation.pdf'); }}" target="_blank">Wall Art Canvas Installation</a> </div>

            <div class="tab-pane fade" id="warranty" role="tabpanel" aria-labelledby="warranty-tab">
              <p><strong>Warranty:</strong>&nbsp;No Warranty</p>
              <p><strong>Return Policy :</strong> <br />
                We  offer a 7-Day Return Policy for all products.<br />
                Returns  are accepted only for the following reasons :<br />
                1)  Damaged Product<br />
                2)  Dead on Arrival<br />
                3)  Manufacturing Defect<br />
                4)  Incomplete Product<br />
                5)  Incorrect Product</p>
              <p>For  more details on the Returns Policy, please refer to the CoCanva Returns Policy.<br />
                Please  note that order once placed cannot be cancelled.</p>
            </div>
            @if (EcommerceHelper::isReviewEnabled())
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
              <div id="list-reviews">
                <div class="comments">
                  <h5 class="product_tab_title">{{ __(':count Reviews For :product', ['count' => $product->reviews_count, 'product' => $product->name]) }}</h5>
                  <product-reviews-component url="{{ route('public.ajax.product-reviews', $product->id) }}"></product-reviews-component>
                </div>
              </div>
              <div class="review_form field_form mt-3">
                <h5>{{ __('Add a review') }}</h5>
                @if (!auth('customer')->check())
                <p class="text-danger">{{ __('Please') }} <a href="{{ route('customer.login') }}">{{ __('login') }}</a> {{ __('to write review!') }}</p>
                @endif
                {!! Form::open(['route' => 'public.reviews.create', 'method' => 'post', 'class' => 'row form-review-product']) !!}
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="star" value="1">
                <div class="form-group col-12">
                  <div class="star_rating"> <span data-value="1"><i class="ion-star"></i></span> <span data-value="2"><i class="ion-star"></i></span> <span data-value="3"><i class="ion-star"></i></span> <span data-value="4"><i class="ion-star"></i></span> <span data-value="5"><i class="ion-star"></i></span> </div>
                </div>
                <div class="form-group col-12">
                  <textarea class="form-control" name="comment" id="txt-comment" rows="4" placeholder="{{ __('Write your review') }}" @if (!auth('customer')->check()) disabled @endif></textarea>
                </div>
                <div class="form-group col-12">
                  <button type="submit" class="btn btn-fill-out @if (!auth('customer')->check()) btn-disabled @endif" @if (!auth('customer')->check()) disabled @endif name="submit" value="Submit">Submit Review</button>
                </div>
                {!! Form::close() !!} </div>
            </div>
            @endif </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="small_divider clearfix"></div>
        <hr>
      </div>
      <div class="col-12">
        <div class="medium_divider clearfix"></div>
      </div>
    </div>
    @php
    $crossSellProducts = get_cross_sale_products($product);
    @endphp
    @if (count($crossSellProducts) > 0)
    <div class="row">
      <div class="col-12">
        <div class="small_divider"></div>
        <div class="divider"></div>
        <div class="medium_divider"></div>
      </div>
    </div>
    <div class="row shop_container grid">
      <div class="col-12">
        <div class="heading_s1">
          <h3>{{ __('Customers who bought this item also bought') }}</h3>
        </div>
        <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'> @foreach ($crossSellProducts as $crossSellProduct)
          {!! Theme::partial('product-item-grid', ['product' => $crossSellProduct]) !!}
          @endforeach </div>
      </div>
    </div>
    @endif
    <div class="row shop_container grid">
      <div class="col-12">
        <div class="heading_s1">
          <h3>{{ __('Related Products') }}</h3>
        </div>
        <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'> @php
          $relatedProducts = get_related_products($product);
          @endphp
          @if (!empty($relatedProducts))
          @foreach ($relatedProducts as $related)
          {!! Theme::partial('product-item-grid', ['product' => $related]) !!}
          @endforeach
          @endif </div>
      </div>
    </div>
  </div>
</div>
<style>
.product-tags{margin-top:10px;}
.product-tags p{margin-bottom:0;}
.product_share{margin-top:0px;}
.product_desc p{margin-bottom: 5px;  font-size: 15px;}
.cart_extra{display:block;}
.cart-product-quantity{display:inline-block;}
.cart_btn{display: inline-block;vertical-align: middle; padding-top: 8px;  float: right;}
.error_div{display:none; width:100%; font-size:13px; color:#F00; }
.errorBox{border-color:#F00; }
</style>
@php
$getNewPriceURL=url('/products/update-custom-attributes-price');
$getWallMuralNewPriceURL=url('/products/update-wall-mural-price');
@endphp
<script>
$(document).ready(function(){
//
// btnQuickCheckout
$('.checkQuickBuy').click(function(){
        // $(this).addClass('btn-disabled button-loading');
		// const crop = getCropImage();
        // console.log('crop', crop)
		// setTimeout(function(){$('.btnQuickCheckout').trigger('click');},300);
		// setTimeout(function(){$('.checkQuickBuy').removeClass('btn-disabled').removeClass('button-loading');},10000);
});
	$('.checkVaidation').click(function(){
        console.log('here');

		if($.trim($('#width_wall_mural_inpt').val()) == "" || $.trim($('#width_wall_mural_inpt').val()) <= 0){
			$('#width_wall_mural_inptErrorMsg').html('This is a required field.').slideDown();
			$('#width_wall_mural_inpt').addClass('errorBox').focus();
			return false;
		}

		if($.trim($('#width_wall_mural_inpt').val()) <= 99){
			$('#width_wall_mural_inptErrorMsg').html('Minimum width is 100cm.').slideDown();
			$('#width_wall_mural_inpt').addClass('errorBox').focus();
			return false;
		}

		if($.trim($('#height_wall_mural_inpt').val()) == "" || $.trim($('#height_wall_mural_inpt').val()) <= 0){
			$('#height_wall_mural_inptErrorMsg').html('This is a required field.').slideDown();
			$('#height_wall_mural_inpt').addClass('errorBox').focus();
			return false;
		}

		if($.trim($('#height_wall_mural_inpt').val()) <= 99){
			$('#height_wall_mural_inptErrorMsg').html('Minimum height is 100cm.').slideDown();
			$('#height_wall_mural_inpt').addClass('errorBox').focus();
			return false;
		}
		if($.trim($('#product_image_material').val()) == "" ){
			$('#product_image_materialErrorMsg').html('This is a required field.').slideDown();
			$('#product_image_material').addClass('errorBox').focus();
			return false;
		}
        // if($.trim($('#image_direction').val()) == "" ){
		// 	$('#image_directionErrorMsg').html('This is a required field.').slideDown();
		// 	$('#image_direction').addClass('errorBox').focus();
		// 	return false;
		// }
        console.log('new here');
        // slick-track slick slide
		$(this).addClass('btn-disabled button-loading');
		const crop = getCropImage();
        console.log('crop', crop)
		setTimeout(function(){$('.btnAddtoCart').trigger('click');},300);
		setTimeout(function(){$('.checkVaidation').removeClass('btn-disabled').removeClass('button-loading');},10000);

	});

	$( "#width_wall_mural_inpt, #height_wall_mural_inpt" ).keyup(function() {
        console.log($('.slick-track:last-child .slick-slide:last-child a')[0].click());

		var idAttr = $(this).attr('id');
		$('#'+idAttr+'ErrorMsg').html('').slideUp();
		$('#'+idAttr).removeClass('errorBox');

		if($.trim($('#'+idAttr).val()) <= 99){
			$('#'+idAttr+'ErrorMsg').html('Minimum value is 100cm.').slideDown();
			$('#'+idAttr).addClass('errorBox').focus();
			return false;
		}

		updateWallMuralPrice();
		updateCropper();
	});

    $( "#width_wall_mural_inpt, #height_wall_mural_inpt" ).change(function() {
        console.log($('.slick-track:last-child .slick-slide:last-child a')[0].click());

		var idAttr = $(this).attr('id');
		$('#'+idAttr+'ErrorMsg').html('').slideUp();
		$('#'+idAttr).removeClass('errorBox');

		if($.trim($('#'+idAttr).val()) <= 99){
			$('#'+idAttr+'ErrorMsg').html('Minimum value is 100cm.').slideDown();
			$('#'+idAttr).addClass('errorBox').focus();
			return false;
		}

		updateWallMuralPrice();
		updateCropper();
	});

	$('#productcolor').val($('input[name="attribute_color"]:checked').val());

    $('.color-swatch li').click(function(){
        var transImage = $.trim($('#getTransparantIMG').val());
        if(transImage != ''){
            var thisData = this;
            var colorStyle = $(thisData).find('span').attr('style');
            $('#product_img').attr({'src':transImage, 'data-zoom-image':transImage, 'style':colorStyle});
			$('.product_gallery_item').removeClass('active');
			$('.trans-img .product_gallery_item').addClass('active');
        }

    });
	$('#image_direction_pr').change(function(){
        var dataID = $(this).attr('data-id');
        var dataVal = $(this).val();
        $('#'+dataID).val(dataVal);

		$('.product_img_box').css({'transform':'rotateY(0deg)'});
		if(dataVal == 'Reversed'){
			$('.product_img_box').css({'transform':'rotateY(180deg)'});
		}

    });
	$('.color-swatch input').change(function(){
        var dataVal = $(this).val();
        $('#productcolor').val(dataVal);
    });

	$('#show-tiles').click(function(){
		$('.Tiles').hide();
		if($(this).prop('checked') == true){
			$('.Tiles').show();
		}
	});

});
$('.wallMural input').keyup(function(){
	var dataID = $(this).attr('data-id');
	var dataVal = $(this).val();
	$('#'+dataID).val(dataVal);
});

function updatePrice(){
	var productID = '{{ $product->id }}';
	var framePrice = $('input[name="product_frame_type"]:checked').attr('data-price');
	var materialPrice = $('#product_image_material').find('option:selected').attr('data-price');
	var sizeElement =  $('#product_image_sizes').find('option:selected');
	var sizeData = sizeElement.val();
	var selectedWidth = sizeElement.attr('data-width');
	var selectedHeight = sizeElement.attr('data-height');
	$.ajaxSetup({headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")}});
	$.ajax({
		type: 'POST',
		url: '{{ $getNewPriceURL }}',
		data: { framePrice:framePrice, sizeData:sizeData, productID:productID, selectedWidth:selectedWidth, selectedHeight:selectedHeight,materialPrice:materialPrice },
		success: function(priceData){
			if(parseFloat(priceData) > 0){
				$('.product_price .product-sale-price-text').html('₹'+priceData);
			}else{
				alert('Something want to wrong, please try after sometime.');
			}

			return false;
		}
	});
}

function updateWallMuralPrice(){
	var selectedWidth = $( "#width_wall_mural_inpt" ).val();
	var selectedHeight = $( "#height_wall_mural_inpt" ).val();
	var materialPrice = $('#product_image_material').find('option:selected').attr('data-price');
	var productID = '{{ $product->id }}';
	var coverEntireWall = $('#image_cover_entire_wall').find('option:selected').val();
	$.ajaxSetup({headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")}});
	$.ajax({
		type: 'POST',
		url: '{{ $getWallMuralNewPriceURL }}',
		data: { productID:productID, selectedWidth:selectedWidth, selectedHeight:selectedHeight,materialPrice:materialPrice,coverEntireWall:coverEntireWall},
		success: function(priceData){
			if(parseFloat(priceData) > 0){
				$('.product_price .product-sale-price-text').html('₹'+priceData);
			}else{
				$('.product_price .product-sale-price-text').html('₹0');
			}
			return false;
		}
	});
}

function previewCrop(){
    let width = $('#width_wall_mural_inpt').val();
    let height = $('#height_wall_mural_inpt').val();
    if(width > 99 && height > 99){
    // const crop = getCropImage();
    const preview = getPreviewImage();

    // console.log('preview', src);
    $('#product_img').attr('src',preview);
    if($('#wallpaper-selector-preview-crop').prop('checked') == false){

    updateCropper();
    }
}

}
</script>

