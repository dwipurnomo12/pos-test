<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'supplier_id' => $this->supplier_id,
            'company_name' => $this->company_name,
            // 'contact_name' => $this->contact_name,
            // 'address' => $this->address,
            // 'city' => $this->city,
            // 'postal_code' => $this->postal_code,
            // 'country' => $this->country,
            // 'phone' => $this->phone,
        ];
    }
}
