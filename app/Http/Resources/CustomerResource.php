<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class CustomerResource extends JsonResource
{
    public static $wrap = null;


    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return $this->resource;
    }
}
