<div class="row cart-item">
    <div class="col-3">
        <div class="checkout-product-img-wrapper">
            <img class="item-thumb img-thumbnail img-rounded" src="{{ Arr::get($cartItem->options, 'image')}}" alt="{{ $product->name }}">
            <span class="checkout-quantity">{{ $cartItem->qty }}</span>
        </div>
    </div>
    <div class="col-5">
        <p class="mb-0">{{ $product->name }}</p>
        <p class="mb-0">
            <small>{{ $cartItem->options['attributes'] ?? $product->variation_attributes }}</small>
        </p>
        @if ($options = Arr::get($cartItem->options, 'extras', []))
            @if (is_array($options))
                @foreach($options as $option)
                    @if (!empty($option['key']) && !empty($option['value']))
                        <p class="mb-0">
                            <small>{{ $option['key'] }}: <strong> {{ $option['value'] }}</strong></small>
                        </p>
                    @endif
                @endforeach
            @endif
        @endif

    </div>
    <div class="col-4 text-right">
        <p>{{ format_price($cartItem->price) }}</p>
    </div>
</div> <!--  /item -->
