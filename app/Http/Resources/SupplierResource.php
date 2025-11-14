<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class SupplierResource extends JsonResource
{
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     
     */
    public function toArray(Request $request): array | Arrayable | JsonSerializable
    {
        return $this->resource;
    }
}
