@php
$variationInfo = $productVariationsInfo;
$variationNextIds = [];
@endphp
@foreach($attributeSets as $set)
@if($set->title == 'Size' )
@include(Theme::getThemeNamespace(). '::views.ecommerce.attributes._layouts.dropdown_type_2', compact('selected'))
@endif
@endforeach