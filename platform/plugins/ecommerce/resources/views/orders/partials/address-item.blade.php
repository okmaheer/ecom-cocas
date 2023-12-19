<div class="address-item @if ($address->is_default) is-default @endif" data-id="{{ $address->id }}">
    <p class="name">{{ $address->name }}</p>
    <p class="address"
       title="{{ $address->address }}, {{ $address->city }}, {{ $address->state }}@if (count(EcommerceHelper::getAvailableCountries()) > 1), {{ $address->country_name }} @endif @if (EcommerceHelper::isZipCodeEnabled() && $address->zip_code), {{ $address->zip_code }} @endif">
        {{ $address->address }}, {{ $address->city }}, {{ $address->state }}@if (count(EcommerceHelper::getAvailableCountries()) > 1), {{ $address->country_name }} @endif @if (EcommerceHelper::isZipCodeEnabled() && $address->zip_code), {{ $address->zip_code }} @endif
    </p>
    <p class="phone">{{ __('Phone') }}: {{ $address->phone }} <?php /*?>@if($address->phone_verify != 1) <a href="javascript:void(0);" onclick="verifyPhone('{{ $address->phone }}', '{{ $address->customer_id }}');" class="verifyBtn">Phone verify</a> @endif<?php */?></p>
    @if ($address->email)
        <p class="email">{{ __('Email') }}: {{ $address->email }}</p>
    @endif
    @if ($address->is_default)
        <span class="default">{{ __('Default') }}</span>
    @endif

</div>
