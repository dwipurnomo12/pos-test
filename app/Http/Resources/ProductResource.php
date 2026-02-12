<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'category' => $this->category->category_name,
            'supplier' => $this->supplier->company_name,
            'unit_price' => $this->unit_price,
            'units_in_stock' => $this->units_in_stock,
            'discontinued' => $this->discontinued,
        ];
    }
}
