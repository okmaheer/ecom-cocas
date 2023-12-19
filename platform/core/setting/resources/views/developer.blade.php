@extends('core/base::layouts.master')
@section('content')
    <div id="main-settings">
        <license-component
            verify-url="{{ route('settings.license.verify') }}"
            activate-license-url="{{ route('settings.license.activate') }}"
            deactivate-license-url="{{ route('settings.license.deactivate') }}"
        ></license-component>
    </div>
    {!! Form::open(['route' => ['settings.edit']]) !!}
        <div class="max-width-1200">
            <div class="flexbox-annotated-section">

                <div class="flexbox-annotated-section-annotation">
                    <div class="annotated-section-title pd-all-20">
                        <h2>Admin Menu</h2>
                    </div>
                    <div class="annotated-section-description pd-all-20 p-none-t">
                        <p class="color-note">Show/Hide left side menu</p>
                    </div>
                </div>

                <div class="flexbox-annotated-section-content">
                    <div class="wrapper-content pd-all-20">
                        <div class="form-group">
                        <label class="text-title-field" for="plugins_manager">Plugins Manager
                        </label>
                        <label class="hrv-label">
                            <input type="radio" name="plugins_manager"  @if (setting('plugins_manager')) checked @endif class="hrv-radio" value="1" >
                            Show
                        </label>
                        <label class="hrv-label">
                            <input type="radio" name="plugins_manager" @if (!setting('plugins_manager')) checked @endif class="hrv-radio" value="0" >
                            Hide
                        </label>
                    </div>


					<div class="form-group">
                        <label class="text-title-field" for="payment_manager">Payment Manager
                        </label>
                        <label class="hrv-label">
                            <input type="radio" name="payment_manager"  @if (setting('payment_manager')) checked @endif class="hrv-radio" value="1" >
                            Show
                        </label>
                        <label class="hrv-label">
                            <input type="radio" name="payment_manager" @if (!setting('payment_manager')) checked @endif class="hrv-radio" value="0" >
                            Hide
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label class="text-title-field" for="themes_manager">Appearance Themes Manager
                        </label>
                        <label class="hrv-label">
                            <input type="radio" name="themes_manager"  @if (setting('themes_manager')) checked @endif class="hrv-radio" value="1" >
                            Show
                        </label>
                        <label class="hrv-label">
                            <input type="radio" name="themes_manager" @if (!setting('themes_manager')) checked @endif class="hrv-radio" value="0" >
                            Hide
                        </label>
                    </div>
                    
                     <div class="form-group">
                        <label class="text-title-field" for="general_settings_manager">General Settings Manager
                        </label>
                        <label class="hrv-label">
                            <input type="radio" name="general_settings_manager"  @if (setting('general_settings_manager')) checked @endif class="hrv-radio" value="1" >
                            Show
                        </label>
                        <label class="hrv-label">
                            <input type="radio" name="general_settings_manager" @if (!setting('general_settings_manager')) checked @endif class="hrv-radio" value="0" >
                            Hide
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label class="text-title-field" for="system_information_manager">System Information Manager
                        </label>
                        <label class="hrv-label">
                            <input type="radio" name="system_information_manager"  @if (setting('system_information_manager')) checked @endif class="hrv-radio" value="1" >
                            Show
                        </label>
                        <label class="hrv-label">
                            <input type="radio" name="system_information_manager" @if (!setting('system_information_manager')) checked @endif class="hrv-radio" value="0" >
                            Hide
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label class="text-title-field" for="payment_manager">Product Height/ Width Increase(%)
                        </label>
                        <input type="number" name="product_hw_percentage"  class="form-control" value="{{setting('product_hw_percentage')}}" maxlength="2" style="width:30%;">
                            
                    </div>
                    
                    <div class="form-group">
                        <label class="text-title-field" for="payment_manager">Cover Entire Wall
                        </label>
                        <input type="number" name="cover_entire_wall"  class="form-control" value="{{setting('cover_entire_wall')}}" maxlength="2" style="width:30%;">
                            
                    </div>
                    </div>
                </div>
                
                

            </div>
            

            <div class="flexbox-annotated-section" style="border: none">
                <div class="flexbox-annotated-section-annotation">
                    &nbsp;
                </div>
                <div class="flexbox-annotated-section-content">
                    <button class="btn btn-info" type="submit">{{ trans('core/setting::setting.save_settings') }}</button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
