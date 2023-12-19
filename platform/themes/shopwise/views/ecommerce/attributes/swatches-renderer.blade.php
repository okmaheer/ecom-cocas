@if($product->id != 114)<div class="product-attributes" data-target="{{ route('public.web.get-variation-by-attributes', ['id' => $product->id]) }}">@endif



    @php



    $variationInfo = $productVariationsInfo;

    $variationNextIds = [];

    @endphp

    @foreach($attributeSets as $set)



    @if (!$loop->first)

    @php

    $variationInfo = $productVariationsInfo->where('attribute_set_id', $set->id)->whereIn('variation_id', $variationNextIds);

    @endphp

    @endif

    @if (view()->exists(Theme::getThemeNamespace(). '::views.ecommerce.attributes._layouts.' . $set->display_layout))



    @if($product->id == 114 || $product->id == 537)

    @if($set->title != 'Size')

    @include(Theme::getThemeNamespace(). '::views.ecommerce.attributes._layouts.dropdown_type_2', compact('selected'))

    @endif

    @else

    @include(Theme::getThemeNamespace(). '::views.ecommerce.attributes._layouts.' . $set->display_layout, compact('selected'))

    @endif

	
    @if($product->product_colors != '' && $loop->index == 0)
        @include(Theme::getThemeNamespace(). '::views.ecommerce.attributes._layouts.color', compact('selected'))
    @endif



    @else

    @include(Theme::getThemeNamespace(). '::views.ecommerce.attributes._layouts.dropdown', compact('selected'))

    @endif

    @php

    [$variationNextIds] = handle_next_attributes_in_product(

    $attributes->where('attribute_set_id', $set->id),

    $productVariationsInfo,

    $set->id,

    $selected->pluck('id')->toArray(),

    $loop->index,

    $variationNextIds);

    @endphp

    @endforeach

    @if($product->id != 114)</div>@endif