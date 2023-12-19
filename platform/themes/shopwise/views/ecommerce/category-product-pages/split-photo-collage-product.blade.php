@php

Theme::asset()->remove('app-js');

Theme::set('pageName', $product->name);

@endphp



@php $category_name=''; @endphp

@foreach ($product->categories()->get() as $category)

@php $category_name = $category->name; @endphp

@endforeach



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.css" />





<div class="section">

    <div class="container">

        <div class="row">

            <div class="col-lg-5 col-md-5 mb-4 mb-md-0">



                <div class="product-image">

                    <div class="product_img_box" id="product_img_box">



                        @if ($product->frame_type !="")

                        @include(Theme::getThemeNamespace() . '::views/ecommerce/split-photo-templates/'.$product->frame_type)

                        @endif



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



                        <!-- For Single Custom Print

                        <div>

                            <h5 class="product_title">Step 1</h5>

                            <input type="file" name="image" class="image" id="upload_image" style="display:none" />

                            <button class="btn btn-fill-out btn-addtocart" type="button" onclick="uploadImage()">

                                <i class="icon-basket-loaded"></i> Upload Image

                            </button>

                        </div>



                        <br>

                        <h5 class="product_title">Step 1</h5>-->

                        <!-- Single Custom Print end -->

                        @if ($product->variations()->count() > 0)

                        <div class="pr_switch_wrap">

                            {!! render_product_swatches($product, [

                            'selected' => $selectedAttrs,

                            'view' => Theme::getThemeNamespace() . '::views.ecommerce.attributes.swatches-renderer'

                            ]) !!}

                        </div>

                        @endif



                        <div class="cart_extra">

                            <input type="file" name="image" class="image" id="upload_image" style="display:none" accept="image/jpeg, image/png" />

                            <form class="add-to-cart-form" method="POST" action="{{ route('public.cart.add-to-cart') }}">



                                <input type="hidden" name="canvasCropImage[]" id="uploaded_crop_image" value="">

                                <input type="hidden" name="canvasMainImage[]" id="uploaded_main_image" value="">

                                <input type="hidden" name="canvasImg" id="canvasImg" value="">



                                @csrf

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

                                    <button class="btn btn-fill-out btn-addtocart @if ($product->isOutOfStock()) btn-disabled @endif" id="btn-pro-addtocart" type="submit" @if ($product->isOutOfStock()) disabled @endif><i class="icon-basket-loaded"></i> {{ __('Add to cart') }}</button>

                                    @endif

                                    @if (EcommerceHelper::isQuickBuyButtonEnabled())

                                    &nbsp;

                                    <button class="btn btn-dark btn-addtocart @if ($product->isOutOfStock()) btn-disabled @endif" type="submit" @if ($product->isOutOfStock()) disabled @endif name="checkout">{{ __('Quick Buy') }}</button>

                                    @endif

                                   <?php /*?> <a class="add_compare js-add-to-compare-button" data-url="{{ route('public.compare.add', $product->id) }}" href="#"><i class="icon-shuffle"></i></a><?php */?>

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

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

            </div>

        </div>

    </div>

</div>

<div class="modal-backdrop fade show" id="backdrop" style="display: none;"></div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.js" integrity="sha512-ZK6m9vADamSl5fxBPtXw6ho6A4TuX89HUbcfvxa2v2NYNT/7l8yFGJ3JlXyMN4hlNbz0il4k6DvqbIW5CCwqkw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



@php

$canvasJS=url('/themes/shopwise/js/canvas.js');

$cropImgUrl=url('/products/crop-images');

$tempImgUrl=url('/images/orders/temp/');

@endphp

<script src="{{ $canvasJS }}"></script>

<script>
 crop_width;
 crop_height;
 left_position;
 leftDivPosition;
 secondDivPosition;

    function closemodal() {

        document.getElementById("backdrop").style.display = "none"

        document.getElementById("modal").style.display = "none"

        document.getElementById("modal").classList.remove("show")

    }



    $(document).ready(function() {



        $("#loading").bind("ajaxStart", function() {

            $(this).show();

        }).bind("ajaxStop", function() {

            alert('ok');

        });



        $("#btn-pro-addtocart").click(function() {

            setTimeout(function() {

                window.location.reload();

            }, 5000);

        });



        var image = document.getElementById('sample_image');

        var cropBoxData;

        var canvasData;

        var cropper;



        $(".uploadImage").click(function() {

            document.getElementById('upload_image').click();

        });



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

                        aspectRatio: crop_width / crop_height,

                        autoCropArea: 1,

                        viewMode: 3,

                        //preview: '.preview'

                    });

                };



                if (files && files.length > 0) {

                    reader = new FileReader();

                    reader.onload = function(event) {

                        done(reader.result);

                        var cropImg = reader.result;

                        convertImage(cropImg, 'mainImage')

                    };

                    reader.readAsDataURL(files[0]);

                }

            } else {

                if (ext != '') {

                    $(this).val(null);

                    alert('Please upload jpg or png image');

                }

                return false;

            }



        });



        $('#crop').click(function() {

            canvas = cropper.getCroppedCanvas({

                width: crop_width,

                height: crop_height,

            });

            // console.log(canvas);

            var dataurl = canvas.toDataURL("image/png");

            //$("#uploaded_image").attr('src', dataurl);



            canvas.toBlob(function(blob) {

                url = URL.createObjectURL(blob);

                var reader = new FileReader();

                reader.readAsDataURL(blob);

                reader.onloadend = function() {

                    var base64data = reader.result;

                    convertImage(base64data, 'frame');

                }

            });



            document.getElementById("backdrop").style.display = "none"

            document.getElementById("modal").style.display = "none"

            document.getElementById("modal").classList.remove('show');

            cropper.reset();

            cropper.clear();

            cropper.destroy();

            $("#upload_image").val('');

        });



    });



    function uploadImage() {

        document.getElementById('upload_image').click();

    }



    function showCropper() {



        cropper = new Cropper(image, {

            autoCropArea: 1,

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



    function setCanvasUrl() {

        $('#frame_download_icon').hide();

        window.scrollTo(0, 0);

        var position = $('#mosaic_wrapper').offset();

        var topPosition = Math.round(position.top) + 4;

        var leftPosition = Math.round(position.left) + left_position;

        var firstboxWidth = $('#mosaic_wrapper .panel:first-child').width() + left_position;

        ///cocas/shopeComm/ 

        $('#mosaic_wrapper .panel').css({ "background-position": leftDivPosition });
        $('#mosaic_wrapper .panel2').css({ "background-position": secondDivPosition });

        //$('#mosaic_wrapper .panel3').css({"background-position" : "-"+firstboxWidth+"px -120px"});

        html2canvas(document.getElementById("main_frame"), {

            maxWidth: 480,

            letterRendering: 1,

            scrollx: (window.pageYOffset * -1),

            scrollY: (window.pageYOffset * -1),

            useCORS: true,

            backgroundColor: null,

            scale: 2

        }).then(function(canvas) {

            convertImage(canvas.toDataURL(), 'canvas');

            $('#mosaic_wrapper .panel').css({

                "background-position": leftPosition + "px " + topPosition + "px"

            });

        });

    }



    var ajaxRequest = 0;



    function convertImage(cropImg, type) {

        $('html, body').css({

            "overflow": "hidden"

        });

        $.ajaxSetup({

            headers: {

                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")

            }

        });

        var canvasName = $('#canvasImg').val();

        var mainImageName = $('#uploaded_main_image').val();

        setTimeout(function() {

            ajaxRequest = parseInt(ajaxRequest) + 1;
			
			if (type == 'canvas') { $('.preloader').show().css({'background':'rgba(255, 255, 255, 0.7)'});}

            $(".btn-pro-addtocart").prop('disabled', true);

            $("#btn-pro-addtocart").html('<i class="icon-basket-loaded"></i> Loading...').prop('disabled', true);

            $.ajax({

                type: 'POST',

                url: '{{ $cropImgUrl }}',

                data: {

                    cropImg: cropImg,

                    type: type,

                    canvasName: canvasName,

                    mainImageName: mainImageName

                },

                success: function(img) {

                    if (type == 'canvas') {

                        $('#canvasImg').val(img);

                        $('#frame_download_icon').show();

                    } else if (type == 'mainImage') {

                        $("#uploaded_main_image").val(img);

                    } else {

                        $("#uploaded_crop_image").val(img);

                        if (type == 'frame') {

                            var position = $('#mosaic_wrapper').offset();

                            var topPosition = Math.round(position.top) + 4;

                            var leftPosition = Math.round(position.left) + left_position;

                            ///cocas/shopeComm/

                            $('#mosaic_wrapper .panel').css({
								
                                "background-image": "url('{{ $tempImgUrl }}/" + img + "')",

                                "background-position": leftPosition + "px " + topPosition + "px",

                                "background-attachment": "fixed",

                                "background-repeat": "no-repeat"

                            });

                            setCanvasUrl();

                        }

                    }

                    ajaxRequest = parseInt(ajaxRequest) - 1;

                    setTimeout(function() {

                        if (parseInt(ajaxRequest) == 0) {

							$('.preloader').hide().css({'background':'#FFF'});
                            $(".btn-pro-addtocart").prop('disabled', false);

                            $("#btn-pro-addtocart").html('<i class="icon-basket-loaded"></i> Add to cart').prop('disabled', false);

                        }

                    }, 2000);

                    return false;

                }

            });

        }, 200);

    }

</script>