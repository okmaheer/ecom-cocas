<?php

namespace Botble\Frame\Providers;

use Illuminate\Routing\Events\RouteMatched;
use Botble\Base\Supports\Helper;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Frame\Models\Frame;
use Botble\Frame\Repositories\Caches\FrameCacheDecorator;
use Botble\Frame\Repositories\Eloquent\FrameRepository;
use Botble\Frame\Repositories\Interfaces\FrameInterface;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Language;

class FrameServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(FrameInterface::class, function () {
            return new FrameCacheDecorator(new FrameRepository(new Frame));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/frame')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        $this->app->booted(function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule([Frame::class]);
            }
        });

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-frame',
                'priority'    => 9,
                'parent_id'   => null,
                'name'        => 'plugins/frame::frame.name',
                'icon'        => 'fa fa-list',
                'url'         => route('frame.index'),
                'permissions' => ['frame.index'],
            ]);
        });
    }
}
