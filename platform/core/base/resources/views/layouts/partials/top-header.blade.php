<style>
@if (!setting('plugins_manager')) #cms-core-plugins{display:none;}  @endif
@if (!setting('payment_manager')) #cms-plugins-payments{display:none;}  @endif
@if (!setting('general_settings_manager')) #cms-core-settings-general{display:none;}  @endif
@if (!setting('system_information_manager')) #cms-core-system-information{display:none;}  @endif
@if (!setting('themes_manager')) #cms-core-theme{display:none;}  @endif

#widget_analytics_general, #widget_analytics_page, #widget_analytics_browser, #widget_analytics_referrer, #dashboard-alerts .note-warning{display:none;}
</style>
<div class="page-header navbar navbar-static-top">
    <div class="page-header-inner">

            <div class="page-logo">
                @if (setting('admin_logo') || config('core.base.general.logo'))
                    <a href="{{ route('dashboard.index') }}">
                        <img src="{{ setting('admin_logo') ? RvMedia::getImageUrl(setting('admin_logo')) : url(config('core.base.general.logo')) }}" alt="logo" class="logo-default" />
                    </a>
                @endif

                @auth
                    <div class="menu-toggler sidebar-toggler">
                        <span></span>
                    </div>
                @endauth
            </div>

            @auth
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
            @endauth

            @include('core/base::layouts.partials.top-menu')
        </div>
</div>
