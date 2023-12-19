<?php

namespace Botble\Ecommerce\Repositories\Caches;

use Botble\Ecommerce\Repositories\Interfaces\OrderProductImagesInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class OrderProductImagesCacheDecorator extends CacheAbstractDecorator implements OrderProductImagesInterface
{
}
