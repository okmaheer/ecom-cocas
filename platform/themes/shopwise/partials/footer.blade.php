    <footer class="footer_dark footer_light">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="widget">
                            @if (theme_option('logo_footer') || theme_option('logo'))
                                <div class="footer_logo">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ RvMedia::getImageUrl(theme_option('logo') ? theme_option('logo') : theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" />
                                    </a>
                                </div>
                            @endif
                            <p>{{ theme_option('about-us') }}</p>
                        </div>
                        <div class="widget">
                            <ul class="social_icons social_white">
                                @if (theme_option('facebook'))
                                    <li><a href="{{ theme_option('facebook') }}" class="sc_facebook" target="_blank"><i class="ion-social-facebook"></i></a></li>
                                @endif
                                @if (theme_option('twitter'))
                                    <li><a href="{{ theme_option('twitter') }}" class="sc_twitter" target="_blank"><i class="ion-social-twitter"></i></a></li>
                                @endif
                                @if (theme_option('youtube'))
                                    <li><a href="{{ theme_option('youtube') }}" class="sc_youtube" target="_blank"><i class="ion-social-youtube-outline"></i></a></li>
                                @endif
                                @if (theme_option('instagram'))
                                    <li><a href="{{ theme_option('instagram') }}" class="sc_instagram" target="_blank"><i class="ion-social-instagram-outline"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    {!! dynamic_sidebar('footer_sidebar') !!}
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="widget">
                            <h6 class="widget_title">{{ __('Contact Info') }}</h6>
                            <ul class="contact_info contact_info_light">
                                @if (theme_option('address'))
                                    <li>
                                        <i class="ti-location-pin"></i>
                                        <p>{{ theme_option('address') }}</p>
                                    </li>
                                @endif
                                @if (theme_option('email'))
                                    <li>
                                        <i class="ti-email"></i>
                                        <a href="mailto:{{ theme_option('email') }}">{{ theme_option('email') }}</a>
                                    </li>
                                @endif
                                @if (theme_option('hotline'))
                                    <li>
                                        <i class="ti-mobile"></i>
                                        <p>{{ theme_option('hotline') }}</p>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom_footer border-top-tran">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-md-0 text-center text-md-left">{{ theme_option('copyright') }}</p>
                    </div>
                    <div class="col-md-6">
                        <ul class="footer_payment text-center text-lg-right">
                            @foreach(json_decode(theme_option('payment_methods', []), true) as $method)
                                @if (!empty($method))
                                    <li><img src="{{ RvMedia::getImageUrl($method) }}" alt="payment method"></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

     @if (is_plugin_active('ecommerce') && EcommerceHelper::isCartEnabled())
         <div id="remove-item-modal" class="modal" tabindex="-1" role="dialog">
             <div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title">{{ __('Warning') }}</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <div class="modal-body">
                         <p>{{ __('Are you sure you want to remove this product from cart?') }}</p>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-fill-out" data-dismiss="modal">{{ __('Cancel') }}</button>
                         <button type="button" class="btn btn-fill-line confirm-remove-item-cart">{{ __('Yes, remove it!') }}</button>
                     </div>
                 </div>
             </div>
         </div>
     @endif

    <a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

    <script>
        window.siteUrl = "{{ url('') }}";
    </script>


    {!! Theme::footer() !!}

    @if (session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg))
    <script type="text/javascript">
            $(document).ready(function () {
                @if (session()->has('success_msg'))
                    window.showAlert('alert-success', '{{ session('success_msg') }}');
                @endif

                @if (session()->has('error_msg'))
                    window.showAlert('alert-danger', '{{ session('error_msg') }}');
                @endif

                @if (isset($error_msg))
                    window.showAlert('alert-danger', '{{ $error_msg }}');
                @endif

                @if (isset($errors))
                    @foreach ($errors->all() as $error)
                        window.showAlert('alert-danger', '{!! $error !!}');
                    @endforeach
                @endif
            });
        </script>
    @endif

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
/*
$(document).ready(function(){
    // For select field attrvbutes
    $(".attr_select").change(function(){
        var selectedAttr = $(this).children("option:selected").html();
       var chars = selectedAttr.trim();
       let pos = chars.indexOf("*");
       let lft = chars.substring(0, pos);
       let end = chars.substring(pos);
       end = end.replace('*','').trim();

       let height = 96 * (parseInt(lft));
       let width = 96 * (parseInt(end));

       document.getElementById("uploaded_image").width = width;
       document.getElementById("uploaded_image").height = height;
    });

        //For text swatches
        $('input[type=radio][class=product-filter-item]').change(function() {
            // alert(this.value);
            let selectedAttr = $(this).attr('data-title');
               var chars = selectedAttr.trim();
               let pos = chars.indexOf("*");
               let lft = chars.substring(0, pos);
               let end = chars.substring(pos);
               end = end.replace('*','').trim();

               let height = 96 * (parseInt(lft));
               let width = 96 * (parseInt(end));

               document.getElementById("uploaded_image").width = width;
               document.getElementById("uploaded_image").height = height;
            
        });

});
*/
</script>

    </body>
</html>
