<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class CustomerCollection extends ResourceCollection
{
    
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return $this->collection->map(
            function ($item) {
                return new CustomerResource($item);
            }
        );
    }
}
