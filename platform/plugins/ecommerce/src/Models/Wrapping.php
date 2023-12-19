<?php

namespace Botble\Ecommerce\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Base\Traits\EnumCastable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wrapping extends BaseModel
{
    use EnumCastable;

    /**
     * @var string
     */
    protected $table = 'wrappings';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'image',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    
}
