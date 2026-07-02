<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->external_id,
            'layout_id'   => $this->layout_id,
            'parent_id'   => $this->parent_id,
            'ordering_id' => $this->ordering_id,
            'name'        => $this->name,
            'region'      => $this->region,
            'created_at'  => $this->created_at?->toISOString(),
            'updated_at'  => $this->updated_at?->toISOString(),
        ];
    }
}
