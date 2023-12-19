@php Theme::set('pageName', __('Wishlist')) @endphp

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive shop_cart_table wishlist-table">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="product-thumbnail">{{ __('Image') }}</th>
                            <th class="product-name">{{ __('Product') }}</th>
                            <th class="product-price">{{ __('Price') }}</th>
                            <th class="product-subtotal">{{ __('Add to cart') }}</th>
                            <th class="product-remove">{{ __('Remove') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if (auth('customer')->check())
                                @if (count($wishlist) > 0 && $wishlist->count() > 0)
                                    @foreach ($wishlist as $item)
                                        @php $item = $item->product; @endphp
                                        <tr>
                                            <td class="product-thumbnail">
                                                <img alt="{{ $item->name }}" width="50" height="70" class="img-fluid"
                                                     style="max-height: 75px"
                                                     src="{{ RvMedia::getImageUrl($item->image, 'thumb', false, RvMedia::getDefaultImage()) }}">
                                            </td>
                                            <td class="product-name" data-title="{{ __('Product') }}">
                                                <a href="{{ $item->original_product->url }}">{{ $item->name }}</a>
                                            </td>
                                            <td class="product-price">
                                                @php
                                                    $sub_categories = Botble\Ecommerce\Models\ProductCategory::where('parent_id', 74)->get();
                                                    $wall_mural_sub_categories =  Botble\Ecommerce\Models\ProductCategory::where('parent_id', 66)->get();
                                                    $wall_sticker_sub_categories =  Botble\Ecommerce\Models\ProductCategory::where('id',65)->first();
                                                    $wall_sticker_childrens = $wall_sticker_sub_categories->childrenRecursive;//->pluck('childrenRecursive')->flatten();
                                                    $wall_sticker_sub_categories = $wall_sticker_childrens? $wall_sticker_childrens->childrenRecursive->pluck('childrenRecursive')->flatten()->pluck('id')->toArray() : [];

                                                    $wall_sticker_categories  = array_merge([65], $wall_sticker_sub_categories);

                                                        $all_categories  = array_merge([74], $sub_categories->pluck('id')->toArray());
                                                        $wall_display_products = $item->categories->whereIn('id', $all_categories);
                                                        if ($wall_display_products->count() > 0) {
                                                            $item->price = $item->price * ($item->wide * $item->height);
                                                        }
                                                        $all_wall_mural_categories  = array_merge([66], $wall_mural_sub_categories->pluck('id')->toArray());
                                                        $wall_mural_products = $item->categories->whereIn('id', $all_wall_mural_categories);
                                                        if ($wall_mural_products->count() > 0) {
                                                            $item->price = $item->price * (100 * 100);
                                                        }

                                                        $wall_sticker_products = $item->categories->whereIn('id', $wall_sticker_categories);
                                                        if ($wall_sticker_products->count() > 0) {
                                                            $item->price = $item->price * ($item->wide * $item->height);
                                                        }
                                                @endphp
                                                <div class="product__price @if ($item->front_sale_price != $item->price) sale @endif">
                                                    <span>{{ format_price($item->front_sale_price_with_taxes) }}</span>
                                                    @if ($item->front_sale_price != $item->price)
                                                        <small><del>{{ format_price($item->price_with_taxes) }}</del></small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="product-remove" data-title="{{ __('Add to cart') }}">
                                                <a class="btn btn-fill-out btn-sm add-to-cart-button" data-id="{{ $item->id }}" href="#" data-url="{{ route('public.cart.add-to-cart') }}">{{ __('Add to cart') }}</a>
                                            </td>
                                            <td class="product-remove" data-title="{{ __('Remove') }}">
                                                <a class="btn btn-dark btn-sm js-remove-from-wishlist-button" href="#" data-url="{{ route('public.wishlist.remove', $item->id) }}">{{ __('Remove') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">{{ __('No product in wishlist!') }}</td>
                                    </tr>
                                @endif
                            @else
                                @if (Cart::instance('wishlist')->count())
                                    @foreach(Cart::instance('wishlist')->content() as $cartItem)
                                        @php
                                            $item = app(\Botble\Ecommerce\Repositories\Interfaces\ProductInterface::class)->findById($cartItem->id);
                                        @endphp
                                        @if (!empty($item))
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <img alt="{{ $item->name }}" width="50" height="70" class="img-fluid"
                                                         style="max-height: 75px"
                                                         src="{{ RvMedia::getImageUrl($item->image, 'thumb', false, RvMedia::getDefaultImage()) }}">
                                                </td>
                                                <td class="product-name" data-title="{{ __('Product') }}">
                                                    <a href="{{ $item->original_product->url }}">{{ $item->name }}</a>
                                                </td>
                                                <td class="product-price" data-title="{{ __('Price') }}">
                                                    @php
                                                    $sub_categories = Botble\Ecommerce\Models\ProductCategory::where('parent_id', 74)->get();
                                                    $wall_mural_sub_categories =  Botble\Ecommerce\Models\ProductCategory::where('parent_id', 66)->get();
                                                    $wall_sticker_sub_categories =  Botble\Ecommerce\Models\ProductCategory::where('id',65)->first();
                                                    $wall_sticker_childrens = $wall_sticker_sub_categories->childrenRecursive;//->pluck('childrenRecursive')->flatten();
                                                    $wall_sticker_sub_categories = $wall_sticker_childrens? $wall_sticker_childrens->childrenRecursive->pluck('childrenRecursive')->flatten()->pluck('id')->toArray() : [];

                                                    $wall_sticker_categories  = array_merge([65], $wall_sticker_sub_categories);

                                                        $all_categories  = array_merge([74], $sub_categories->pluck('id')->toArray());
                                                        $wall_display_products = $item->categories->whereIn('id', $all_categories);
                                                        if ($wall_display_products->count() > 0) {
                                                            $item->price = $item->price * ($item->wide * $item->height);
                                                        }
                                                        $all_wall_mural_categories  = array_merge([66], $wall_mural_sub_categories->pluck('id')->toArray());
                                                        $wall_mural_products = $item->categories->whereIn('id', $all_wall_mural_categories);
                                                        if ($wall_mural_products->count() > 0) {
                                                            $item->price = $item->price * (100 * 100);
                                                        }

                                                        $wall_sticker_products = $item->categories->whereIn('id', $wall_sticker_categories);
                                                        if ($wall_sticker_products->count() > 0) {
                                                            $item->price = $item->price * ($item->wide * $item->height);
                                                        }
                                                @endphp
                                                    <div class="product__price @if ($item->front_sale_price != $item->price) sale @endif">
                                                        <span>{{ format_price($item->front_sale_price_with_taxes) }}</span>
                                                        @if ($item->front_sale_price != $item->price)
                                                            <small><del>{{ format_price($item->price_with_taxes) }}</del></small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="product-remove" data-title="{{ __('Add to cart') }}">
                                                    <a class="btn btn-fill-out btn-sm add-to-cart-button" data-id="{{ $item->id }}" href="{{ route('public.cart.add-to-cart') }}">{{ __('Add to cart') }}</a>
                                                </td>
                                                <td class="product-remove" data-title="{{ __('Remove') }}">
                                                    <a class="btn btn-dark btn-sm js-remove-from-wishlist-button" href="#" data-url="{{ route('public.wishlist.remove', $item->id) }}">{{ __('Remove') }}</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">{{ __('No product in wishlist!') }}</td>
                                    </tr>
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>

                @if (auth('customer')->check())
                    <div class="mt-3 justify-content-center pagination_style1">
                        {!! $wishlist->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
