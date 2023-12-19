<?php

namespace Theme\Shopwise\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use RvMedia;

class MeterialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'price' => $this->price,
            'image'   => RvMedia::getImageUrl($this->image, null, false, RvMedia::getDefaultImage()),
        ];
    }
}
