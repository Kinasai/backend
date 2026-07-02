<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TagCollection extends ResourceCollection
{
    public $collects = CategoryResource::class;

    public function toArray(Request $request): array
    {
        return [
            'page_total' => $this->lastPage(),
            'tag_count' => $this->total(),
            'page' => $this->currentPage(),
            'tags' => TagResource::collection($this->collection),
            'product_code' => config('product.code'),
            'product_name' => config('product.name'),
            ];
    }
}
