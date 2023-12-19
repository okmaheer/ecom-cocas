<?php

namespace Botble\Wrapping\Providers;

use Illuminate\Routing\Events\RouteMatched;
use Botble\Base\Supports\Helper;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Wrapping\Models\Wrapping;
use Botble\Wrapping\Repositories\Caches\WrappingCacheDecorator;
use Botble\Wrapping\Repositories\Eloquent\WrappingRepository;
use Botble\Wrapping\Repositories\Interfaces\WrappingInterface;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Language;

class WrappingServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(WrappingInterface::class, function () {
            return new WrappingCacheDecorator(new WrappingRepository(new Wrapping));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/wrapping')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        $this->app->booted(function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule([Wrapping::class]);
            }
        });

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-wrapping',
                'priority'    => 10,
                'parent_id'   => null,
                'name'        => 'plugins/wrapping::wrapping.name',
                'icon'        => 'fa fa-list',
                'url'         => route('wrapping.index'),
                'permissions' => ['wrapping.index'],
            ]);
        });
    }
}
