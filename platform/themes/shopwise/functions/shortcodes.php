<?php

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Theme\Supports\ThemeSupport;

app()->booted(function () {

    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    if (is_plugin_active('ecommerce')) {
        add_shortcode('featured-product-categories', __('Featured Product Categories'),
            __('Featured Product Categories'),
            function ($shortcode) {

                return Theme::partial('shortcodes.featured-product-categories', [
                    'title'       => $shortcode->title,
                    'description' => $shortcode->description,
                    'subtitle'    => $shortcode->subtitle,
                ]);
            });

        shortcode()->setAdminConfig('featured-product-categories', function ($attributes) {
            return Theme::partial('shortcodes.featured-product-categories-admin-config', compact('attributes'));
        });

        add_shortcode('featured-brands', __('Featured Brands'), __('Featured Brands'), function ($shortcode) {
            return Theme::partial('shortcodes.featured-brands', [
                'title' => $shortcode->title,
            ]);
        });

        shortcode()->setAdminConfig('featured-brands', function ($attributes) {
            return Theme::partial('shortcodes.featured-brands-admin-config', compact('attributes'));
        });

        add_shortcode('product-collections', __('Product Collections'), __('Product Collections'),
            function ($shortcode) {
                $productCollections = get_product_collections(['status' => BaseStatusEnum::PUBLISHED], [],
                    ['id', 'name', 'slug'])->toArray();

                return Theme::partial('shortcodes.product-collections', [
                    'title'              => $shortcode->title,
                    'productCollections' => $productCollections,
                ]);
            });

        shortcode()->setAdminConfig('product-collections', function ($attributes) {
            return Theme::partial('shortcodes.product-collections-admin-config', compact('attributes'));
        });

        add_shortcode('trending-products', __('Trending Products'), __('Trending Products'), function ($shortcode) {
            return Theme::partial('shortcodes.trending-products', [
                'title' => $shortcode->title,
            ]);
        });

        shortcode()->setAdminConfig('trending-products', function ($attributes) {
            return Theme::partial('shortcodes.trending-products-admin-config', compact('attributes'));
        });

        add_shortcode('product-blocks', __('Product Blocks'), __('Product Blocks'), function ($shortcode) {
            return Theme::partial('shortcodes.product-blocks', [
                'featured_product_title'  => $shortcode->featured_product_title,
                'top_rated_product_title' => $shortcode->top_rated_product_title,
                'on_sale_product_title'   => $shortcode->on_sale_product_title,
            ]);
        });

        shortcode()->setAdminConfig('product-blocks', function ($attributes) {
            return Theme::partial('shortcodes.product-blocks-admin-config', compact('attributes'));
        });

        add_shortcode('all-products', __('All Products'), __('All Products'), function ($shortcode) {
            $products = get_products([
                'paginate' => [
                    'per_page'      => $shortcode->per_page,
                    'current_paged' => (int)request()->input('page'),
                ],
            ]);

            return Theme::partial('shortcodes.all-products', [
                'title'    => $shortcode->title,
                'products' => $products,
            ]);
        });

        shortcode()->setAdminConfig('all-products', function ($attributes) {
            return Theme::partial('shortcodes.all-products-admin-config', compact('attributes'));
        });

        add_shortcode('all-brands', __('All Brands'), __('All Brands'), function ($shortcode) {
            $brands = get_all_brands();

            return Theme::partial('shortcodes.all-brands', [
                'title'  => $shortcode->title,
                'brands' => $brands,
            ]);
        });

        shortcode()->setAdminConfig('all-brands', function ($attributes) {
            return Theme::partial('shortcodes.all-brands-admin-config', compact('attributes'));
        });

        add_shortcode('flash-sale', __('Flash sale'), __('Flash sale'), function ($shortcode) {
            return Theme::partial('shortcodes.flash-sale', [
                'title' => $shortcode->title,
            ]);
        });

        shortcode()->setAdminConfig('flash-sale', function ($attributes) {
            return Theme::partial('shortcodes.flash-sale-admin-config', compact('attributes'));
        });
    }

    add_shortcode('banners', __('Banners'), __('Banners'), function ($shortcode) {
        return Theme::partial('shortcodes.banners', [
            'image1' => $shortcode->image1,
            'url1'   => $shortcode->url1,
            'image2' => $shortcode->image2,
            'url2'   => $shortcode->url2,
            'image3' => $shortcode->image3,
            'url3'   => $shortcode->url3,
        ]);
    });

    shortcode()->setAdminConfig('banners', function ($attributes) {
        return Theme::partial('shortcodes.banners-admin-config', compact('attributes'));
    });

    add_shortcode('our-features', __('Our features'), __('Our features'), function ($shortcode) {
        return Theme::partial('shortcodes.our-features', compact('shortcode'));
    });

    shortcode()->setAdminConfig('our-features', function ($attributes) {
        return Theme::partial('shortcodes.our-features-admin-config', compact('attributes'));
    });

    if (is_plugin_active('testimonial')) {
        add_shortcode('testimonials', __('Testimonials'), __('Testimonials'), function ($shortcode) {
            return Theme::partial('shortcodes.testimonials', [
                'title' => $shortcode->title,
            ]);
        });

        shortcode()->setAdminConfig('testimonials', function ($attributes) {
            return Theme::partial('shortcodes.testimonials-admin-config', compact('attributes'));
        });
    }
	
	 if (is_plugin_active('material')) {
        add_shortcode('material', __('Materials'), __('Materials'), function ($shortcode) {
            return Theme::partial('shortcodes.material', [
                'title' => $shortcode->title,
            ]);
        });

        shortcode()->setAdminConfig('material', function ($attributes) {
            return Theme::partial('shortcodes.materials-admin-config', compact('attributes'));
        });
    }
	
	 if (is_plugin_active('frames')) {
        add_shortcode('frame', __('Frames'), __('Frames'), function ($shortcode) {
            return Theme::partial('shortcodes.frame', [
                'title' => $shortcode->title,
            ]);
        });

        shortcode()->setAdminConfig('frame', function ($attributes) {
            return Theme::partial('shortcodes.frames-admin-config', compact('attributes'));
        });
    }
	
	 if (is_plugin_active('wrappings')) {
        add_shortcode('wrapping', __('Wrappings'), __('Wrappings'), function ($shortcode) {
            return Theme::partial('shortcodes.wrapping', [
                'title' => $shortcode->title,
            ]);
        });

        shortcode()->setAdminConfig('wrapping', function ($attributes) {
            return Theme::partial('shortcodes.wrappings-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('newsletter')) {
        add_shortcode('newsletter-form', __('Newsletter Form'), __('Newsletter Form'), function ($shortcode) {
            return Theme::partial('shortcodes.newsletter-form', [
                'title'       => $shortcode->title,
                'description' => $shortcode->description,
                'subtitle'    => $shortcode->subtitle,
            ]);
        });

        shortcode()->setAdminConfig('newsletter-form', function ($attributes) {
            return Theme::partial('shortcodes.newsletter-form-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('contact')) {
        add_filter(CONTACT_FORM_TEMPLATE_VIEW, function () {
            return Theme::getThemeNamespace() . '::partials.shortcodes.contact-form';
        }, 120);
    }

    if (is_plugin_active('blog')) {
        add_shortcode('featured-news', __('Featured News'), __('Featured News'), function ($shortcode) {
            return Theme::partial('shortcodes.featured-news', [
                'title'       => $shortcode->title,
                'description' => $shortcode->description,
                'subtitle'    => $shortcode->subtitle,
            ]);
        });
        shortcode()->setAdminConfig('featured-news', function ($attributes) {
            return Theme::partial('shortcodes.featured-news-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('simple-slider')) {
        add_filter(SIMPLE_SLIDER_VIEW_TEMPLATE, function () {
            return Theme::getThemeNamespace() . '::partials.shortcodes.sliders';
        }, 120);
    }
});
