@php

Theme::asset()->remove('app-js');

Theme::set('pageName', $product->name);

@endphp



@php $category_name=''; @endphp

@foreach ($product->categories()->get() as $category)

@php $category_name = $category->name; @endphp

@endforeach



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.css" />



<style>

    .btn-edit-modal-Image {

        display: none;

    }

</style>



<div class="section">

    <div class="container">

        <div class="row">

            <div class="col-lg-5 col-md-5 mb-4 mb-md-0">



                <div class="product-image">

                    <div class="product_img_box" style="height:100%">

                        <img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image">

                    </div>

                </div>



                <div class="product-image d-none">

                    <div class="product_img_box">

                        <img id="product_img" src="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}" data-zoom-enable="true" data-zoom-image="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}" />

                        <a href="#" class="product_img_zoom" title="Zoom">

                            <span class="linearicons-zoom-in"></span>

                        </a>

                    </div>

                    <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">

                        @foreach ($productImages as $img)

                        <div class="item">

                            <a href="#" class="product_gallery_item @if ($loop->first) active @endif" data-image="{{ RvMedia::getImageUrl($img) }}" data-zoom-image="{{ RvMedia::getImageUrl($img) }}">

                                <img src="{{ RvMedia::getImageUrl($img, 'thumb') }}" alt="{{ $product->name }}" />

                            </a>

                        </div>

                        @endforeach

                    </div>

                </div>

            </div>

            <div class="col-lg-7 col-md-7">

                <div class="pr_detail">

                    <div class="product_description">

                        <h4 class="product_title"><a href="{{ $product->url }}">{{ $product->name }}</a></h4>

                        <div class="product_price">

                            <span class="price product-sale-price-text">{{ format_price($product->front_sale_price_with_taxes) }}</span>

                            <del class="product-price-text" @if ($product->front_sale_price == $product->price) style="display: none" @endif>{{ format_price($product->price_with_taxes) }}</del>

                            <div class="on_sale" @if ($product->front_sale_price == $product->price) style="display: none" @endif>

                                <span class="on_sale_percentage_text">{{ get_sale_percentage($product->price, $product->front_sale_price) }}</span> <span>{{ __('Off') }}</span>

                            </div>

                        </div>

                        @if (EcommerceHelper::isReviewEnabled())

                        @if ($product->reviews_count > 0)

                        <div class="rating_wrap">

                            <div class="rating">

                                <div class="product_rate" style="width: {{ $product->reviews_avg * 20 }}%"></div>

                            </div>

                            <span class="rating_num">({{ $product->reviews_count }})</span>

                        </div>

                        @endif

                        @endif

                        <div class="clearfix"></div>



                        <hr />



                        <!-- For Single Custom Print -->

                        <div class="product-attributes" data-target="{{ route('public.web.get-variation-by-attributes', ['id' => $product->id]) }}">

                            <div>

                                <h5 class="product_title">Step 1</h5>

                                @if ($product->variations()->count() > 0)

                                <div class="pr_switch_wrap" id="prod_switch">

                                    {!! render_product_swatches_type_1($product, [

                                    'selected' => $selectedAttrs,

                                    'view' => Theme::getThemeNamespace() . '::views.ecommerce.attributes.swatches-renderer-option-1'

                                    ]) !!}

                                </div>

                                @endif

                            </div>



                            <br>

                            <h5 class="product_title">Step 2</h5>

                            <!-- Single Custom Print end -->



                            <input type="file" name="image" class="image" id="upload_image" onchange="$('#productImageError').html('').hide();" style="display:none" accept="image/jpeg, image/png" />

                            <input type="hidden" name="canvasSize" id="canvasSize" value="0">

                            <button class="btn btn-fill-out btn-addtocart btn-upload-modal-Image" type="button" onclick="uploadImage()" style="margin-bottom:10px;">

                                <i class="icon-basket-loaded"></i> Upload Image

                            </button>

                            <br>

                            <button class="btn btn-fill-out btn-addtocart btn-edit-modal-Image" type="button" onclick="uploadImage()">

                                <i class="icon-basket-loaded"></i> Edit Image

                            </button>

                            <span id="productImageError" style="color:#F00; font-size:13px; display:none;"></span>



                            @if ($product->variations()->count() > 0)

                            <div class="pr_switch_wrap" id="prod_switch">

                                {!! render_product_swatches($product, [

                                'selected' => $selectedAttrs,

                                'view' => Theme::getThemeNamespace() . '::views.ecommerce.attributes.swatches-renderer'

                                ]) !!}


                            </div>

                            @endif

                        </div>



                        <div class="cart_extra">

                            <form class="add-to-cart-form" method="POST" action="{{ route('public.cart.add-to-cart') }}">

                                @csrf

                                <input type="hidden" name="customCropImage" id="customCropImage" value="">
                                <div class="attribute-name">Color Effect</div>
                                <div class="dropdown-swatch">
                                    <label>
                                        <label>
                                            <select name="color_effect" id="coloreffect" onchange="colorEffect()" class="form-control attr_select">
                                                <option selected="" data-color-type="color" value="none" label="Full colour">
                                                    Full colour
                                                </option>
                                                <option data-color-type="color" value="blackwhite" label="Black &amp; White">
                                                    Black &amp; White
                                                </option>
                                                <option data-color-type="color" value="grayscale" label="Grayscale">
                                                    Grayscale
                                                </option>
                                                <option data-color-type="filter" value="invert" label="Invert">
                                                    Invert
                                                </option>
                                                <option data-color-type="filter" value="pixelate" label="Piexelate">
                                                    Pixelate
                                                </option>
                                                <option data-color-type="color" value="sepia" label="Sepia">
                                                    Sepia
                                                </option>
                                            </select>
                                        </label>
                                    </label>
                                </div>

                                <div class="attribute-name">Canvas Type</div>
                                <div class="dropdown-swatch">
                                    <label>
                                        <label>
                                            <select name="canvas_type" id="canvastype" class="form-control attr_select">
                                                <option value="single" label="Single Canvas">Single Canvas</option>
                                                <option value="large" label="Large Canvas">Large Canvas</option>
                                                <option value="rolled" label="Rolled Canvas">Rolled Canvas</option>
                                            </select>
                                        </label>
                                    </label>
                                </div>

                                {!! apply_filters(ECOMMERCE_PRODUCT_DETAIL_EXTRA_HTML, null) !!}

                                <input type="hidden" name="id" id="hidden-product-id" value="{{ ($product->is_variation || !$product->defaultVariation->product_id) ? $product->id : $product->defaultVariation->product_id }}" />

                                @if (EcommerceHelper::isCartEnabled())

                                <div class="cart-product-quantity">

                                    <div class="quantity float-left">

                                        <input type="button" value="-" class="minus">

                                        <input type="text" name="qty" value="1" title="{{ __('Qty') }}" class="qty" size="4">

                                        <input type="button" value="+" class="plus">

                                    </div> &nbsp;

                                    <div class="float-right number-items-available" style="@if (!$product->isOutOfStock()) display: none; @endif line-height: 45px;">

                                        @if ($product->isOutOfStock())

                                        <span class="text-danger">({{ __('Out of stock') }})</span>

                                        @endif

                                    </div>

                                </div>

                                <br>

                                @endif

                                <div class="cart_btn">

                                    @if (EcommerceHelper::isCartEnabled())

                                    <button class="btn btn-fill-out btn-addtocart @if ($product->isOutOfStock()) btn-disabled @endif" type="submit" @if ($product->isOutOfStock()) disabled @endif><i class="icon-basket-loaded"></i> {{ __('Add to cart') }}</button>

                                    @endif

                                    @if (EcommerceHelper::isQuickBuyButtonEnabled())

                                    &nbsp;

                                    <button class="btn btn-dark btn-addtocart @if ($product->isOutOfStock()) btn-disabled @endif" type="submit" @if ($product->isOutOfStock()) disabled @endif name="checkout">{{ __('Quick Buy') }}</button>

                                    @endif

                                    <?php /*?><a class="add_compare js-add-to-compare-button" data-url="{{ route('public.compare.add', $product->id) }}" href="#"><i class="icon-shuffle"></i></a><?php */?>

                                    <a class="add_wishlist js-add-to-wishlist-button" href="#" data-url="{{ route('public.wishlist.add', $product->id) }}"><i class="icon-heart"></i></a>

                                </div>

                                <br>

                                <div class="success-message text-success" style="display: none;">

                                    <span></span>

                                </div>

                                <div class="error-message text-danger" style="display: none;">

                                    <span></span>

                                </div>

                            </form>

                        </div>

                        <hr />

                        <ul class="product-meta">

                            <li>{{ __('SKU') }}: <span id="product-sku">{{ $product->sku }}</span></li>

                            <li>{{ __('Category') }}:

                                @foreach ($product->categories()->get() as $category)

                                <a href="{{ $category->url }}">{{ $category->name }}</a>@if (!$loop->last),@endif

                                @endforeach

                            </li>

                            @if (!$product->tags->isEmpty())

                            <li>{{ __('Tags') }}:

                                @foreach ($product->tags as $tag)

                                <a href="{{ $tag->url }}" rel="tag">{{ $tag->name }}</a>@if (!$loop->last),@endif

                                @endforeach

                            </li>

                            @endif

                        </ul>



                        <div class="product_share">

                            <span>{{ __('Share') }}:</span>

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

                <div class="large_divider clearfix"></div>

            </div>

        </div>

        <div class="row">

            <div class="col-12">

                <div class="tab-style3">

                    <ul class="nav nav-tabs" role="tablist">

                        <li class="nav-item">

                            <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">{{ __('Description') }}</a>

                        </li>

                        @if (EcommerceHelper::isReviewEnabled())

                        <li class="nav-item">

                            <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">{{ __('Reviews') }} ({{ $product->reviews_count }})</a>

                        </li>

                        @endif

                    </ul>

                    <div class="tab-content shop_info_tab">

                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">

                            <div id="app">

                                {!! clean($product->content) !!}

                            </div>

                            @if (theme_option('facebook_comment_enabled_in_product', 'yes') == 'yes')

                            <br />

                            {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, Theme::partial('comments')) !!}

                            @endif

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

                                    <div class="star_rating">

                                        <span data-value="1"><i class="ion-star"></i></span>

                                        <span data-value="2"><i class="ion-star"></i></span>

                                        <span data-value="3"><i class="ion-star"></i></span>

                                        <span data-value="4"><i class="ion-star"></i></span>

                                        <span data-value="5"><i class="ion-star"></i></span>

                                    </div>

                                </div>

                                <div class="form-group col-12">

                                    <textarea class="form-control" name="comment" id="txt-comment" rows="4" placeholder="{{ __('Write your review') }}" @if (!auth('customer')->check()) disabled @endif></textarea>

                                </div>

                                <div class="form-group col-12">

                                    <button type="submit" class="btn btn-fill-out @if (!auth('customer')->check()) btn-disabled @endif" @if (!auth('customer')->check()) disabled @endif name="submit" value="Submit">Submit Review</button>

                                </div>

                                {!! Form::close() !!}

                            </div>

                        </div>

                        @endif

                    </div>

                </div>

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

                <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>

                    @foreach ($crossSellProducts as $crossSellProduct)

                    {!! Theme::partial('product-item-grid', ['product' => $crossSellProduct]) !!}

                    @endforeach

                </div>

            </div>

        </div>

        @endif



        <div class="row shop_container grid">

            <div class="col-12">

                <div class="heading_s1">

                    <h3>{{ __('Related Products') }}</h3>

                </div>

                <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>

                    @php

                    $relatedProducts = get_related_products($product);

                    @endphp

                    @if (!empty($relatedProducts))

                    @foreach ($relatedProducts as $related)

                    {!! Theme::partial('product-item-grid', ['product' => $related]) !!}

                    @endforeach

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>



<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Crop Image Before Upload</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal()">

                    <span aria-hidden="true">×</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="img-container">

                    <div class="row">

                        <div class="col-md-8">

                            <img src="" id="sample_image" height="100%" width="100%" />

                        </div>

                        <div class="col-md-4">

                            <div class="preview"></div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" id="crop" class="btn btn-primary">Crop</button>

                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closemodal()">Cancel</button>

            </div>

        </div>

    </div>

</div>

<div class="modal-backdrop fade show" id="backdrop" style="display: none;"></div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.js"></script>



<script>
    function colorEffect(){
    let color = $('#coloreffect').val();
    console.log(color)
    $('.product-image').css('filter','none');
    if(color == "grayscale"){
    $('.product-image').css('filter','grayscale(100%)');
    }
    else if(color == "invert"){
    $('.product-image').css('filter','invert(100%)');
    }
    else if(color == "sepia"){
    $('.product-image').css('filter','sepia(100%)');
    }
    else if(color == "blackwhite"){
    $('.product-image').css('filter','grayscale(100%)');
    }
    else if(color == "pixelate"){
    $('.product-image').css('image-rendering','pixelated');
    }

    $('#color_effect').val(color);
}
var size = document.getElementById("set_Size");

size.addEventListener('change', function() {
    let size = $("#set_Size option:selected").text().trim();
    let split = size.split("*");
    let sum = split[0] * split[1];
    let canvas_type = $("#canvastype")
    if(sum >= 100 && sum < 200){
        canvas_type.val("large");
    }
    else if(sum >= 200){
        canvas_type.val("rolled");
    }
    else{
        canvas_type.val("single");
    }
});



    function closemodal() {

        document.getElementById("backdrop").style.display = "none"

        document.getElementById("modal").style.display = "none"

        document.getElementById("modal").classList.remove("show")

    }



    /*function openmodal() {

        document.getElementById("backdrop").style.display = "block"

        document.getElementById("modal").style.display = "block"

        document.getElementById("modal").classList.add("show")

    }*/



    $(document).ready(function() {

        var image = document.getElementById('sample_image');

        var cropBoxData;

        var canvasData;

        var cropper;

        var initialAspectValue = $("#prod_switch .product-attributes .attribute-swatches-wrapper:first-child .attribute-values .dropdown-swatch .attr_select .product-filter-item:first-child").text().trim();



        var aspectArr = initialAspectValue.split('*');



        var initialAspectRatio = (aspectArr[0] / aspectArr[1]);



        $("#canvasSize").val(initialAspectRatio);



        $("#upload_image").change(function(event) {



            if (cropper) {

                cropper.destroy();

                $("#sample_image").src = '';

            }

            var files = event.target.files;



            var fileName = $(this).val();

            var ext = fileName.substring(fileName.lastIndexOf('.') + 1);

            if (ext == "jpg" || ext == "jpeg" || ext == "JPG" || ext == "JPEG" || ext == "png" || ext == "PNG") {



                var done = function(url) {

                    image.src = url;

                    document.getElementById("backdrop").style.display = "block"

                    document.getElementById("modal").style.display = "block"

                    document.getElementById("modal").classList.add("show")

                    cropper = new Cropper(image, {



                        aspectRatio: $("#canvasSize").val(),

                        viewMode: 3,

                        preview: '.preview'

                    });

                };



                if (files && files.length > 0) {

                    reader = new FileReader();

                    reader.onload = function(event) {

                        done(reader.result);

                        $("#customMainImage").val(reader.result);

                    };

                    reader.readAsDataURL(files[0]);





                }

            } else {

                if (ext != '') {

                    $(this).val(null);

                    $('#productImageError').fadeIn().html('Please upload jpg or png image');

                }

                return false;

            }



        });



        $('#crop').click(function() {

            canvas = cropper.getCroppedCanvas({

                // width: 800,

                // height: 800

                minWidth: 256,

                minHeight: 256,

                maxWidth: 4096,

                maxHeight: 4096,

            });



            // console.log(canvas);



            var dataurl = canvas.toDataURL("image/png");



            $("#uploaded_image").attr('src', dataurl);



            canvas.toBlob(function(blob) {

                url = URL.createObjectURL(blob);

                var reader = new FileReader();

                reader.readAsDataURL(blob);



                reader.onloadend = function() {

                    var base64data = reader.result;

                    $("#customCropImage").val(base64data);

                    // console.log(base64data);

                }

            });







            document.getElementById("backdrop").style.display = "none"

            document.getElementById("modal").style.display = "none"

            document.getElementById("modal").classList.remove('show');



            $('.btn-edit-modal-Image').show();

            $('.btn-upload-modal-Image').hide();



            cropper.reset();

            cropper.clear();

            cropper.destroy();

        });

    });



    function uploadImage() {

        if ($.trim($('#set_Size').val()) <= 0) {

            alert('Please select the size');

            return false;

        }

        document.getElementById('upload_image').click();

    }





    function showCropper() {



        cropper = new Cropper(image, {

            autoCropArea: 0.5,

            ready: function() {

                //Should set crop box data first here

                cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);

            }

        });

    }



    var loadFile = function(event, elem) {

        var output = document.getElementById(elem);

        output.src = URL.createObjectURL(event.target.files[0]);

        output.onload = function() {

            URL.revokeObjectURL(output.src) // free memory

        }

    };

</script>
