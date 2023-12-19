<div class="dropdown-swatches-wrapper attribute-swatches-wrapper" data-type="dropdown">
    <div class="attribute-name">{{ $set->title }}</div>
    <div class="attribute-values">
        <div class="dropdown-swatch">
            <label>
                <select class="form-control attr_select">
                    @foreach($attributes->where('attribute_set_id', $set->id) as $attribute)
                        <option class="product-filter-item"
                                value="{{ $attribute->id }}"
                                data-id="{{ $attribute->id }}"
                                @if (!$variationInfo->where('id', $attribute->id)->count()) disabled="disabled" @endif>
                            {{ $attribute->title }}
                        </option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>
</div>
