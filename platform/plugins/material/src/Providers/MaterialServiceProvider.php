<?php

namespace Botble\Material\Providers;

use Illuminate\Routing\Events\RouteMatched;
use Botble\Base\Supports\Helper;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Material\Models\Material;
use Botble\Material\Repositories\Caches\MaterialCacheDecorator;
use Botble\Material\Repositories\Eloquent\MaterialRepository;
use Botble\Material\Repositories\Interfaces\MaterialInterface;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Language;

class MaterialServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(MaterialInterface::class, function () {
            return new MaterialCacheDecorator(new MaterialRepository(new Material));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/material')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        $this->app->booted(function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule([Material::class]);
            }
        });

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-material',
                'priority'    => 9,
                'parent_id'   => null,
                'name'        => 'plugins/material::material.name',
                'icon'        => 'fa fa-list',
                'url'         => route('material.index'),
                'permissions' => ['material.index'],
            ]);
        });
    }
}
