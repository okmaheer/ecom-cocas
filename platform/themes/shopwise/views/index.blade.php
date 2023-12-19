@php
    Theme::layout('homepage')
@endphp

<div class="container">
    <div style="margin: 40px 0;">
        <h4 style="color: #f00; margin-bottom: 15px;">You need to setup your homepage first!</h4>

        <p><strong>1. Go to Admin -> Plugins then activate all plugins.</strong></p>
        <p><strong>2. Go to Admin -> Pages and create a page:</strong></p>

        <div style="margin: 20px 0;">
            <div>- Content:</div>
            <div style="border: 1px solid rgba(0,0,0,.1); padding: 10px; margin-top: 10px;">
                <div>[simple-slider key="home-slider"][/simple-slider]</div>
                <div>[featured-product-categories title="Top Categories" subtitle="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim Nullam nunc varius."][/featured-product-categories]</div>
                <div>[flash-sale title="Best deals for you"][/flash-sale]</div>
                <div>[product-collections title="Exclusive Products"][/product-collections]</div>
                <div>[banners image1="general/b-1.jpg" url1="/product-categories/headphone" image2="general/b-2.jpg" url2="/product-categories/camera" image3="general/b-3.jpg" url3="/product-categories/watches"][/banners]</div>
                <div>[trending-products title="Trending Products"][[/trending-products]</div>
                <div>[product-blocks featured_product_title="Featured Products" top_rated_product_title="Top Rated Products" on_sale_product_title="On Sale Products"][/product-blocks]</div>
                <div>[featured-brands title="Our Brands"][/featured-brands]</div>
                <div>[featured-news title="Visit Our Blog" subtitle="Our Blog updated the newest trend of the world regularly"][/featured-news]</div>
                <div>[testimonials title="Our Client Say!"][/testimonials]</div>
                <div>[our-features icon1="flaticon-shipped" title1="Free Delivery" subtitle1="Free shipping on all US order or order above $200" icon2="flaticon-money-back" title2="30 Day Returns Guarantee" subtitle2="Simply return it within 30 days for an exchange" icon3="flaticon-support" title3="27/4 Online Support" subtitle3="Contact us 24 hours a day, 7 days a week"][/our-features]</div>
                <div>[newsletter-form title="Join Our Newsletter Now" subtitle="Register now to get updates on promotions."][/newsletter-form]</div>
            </div>
            <br>
            <div>- Template: <strong>Homepage</strong>.</div>
        </div>

        <p><strong>3. Then go to Admin -> Appearance -> Theme options -> Page to set your homepage.</strong></p>
    </div>
</div>
