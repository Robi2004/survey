<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExcelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'Nom' => $this->when($request->lastName == 'true', $this->lastName),
            'Prénom' => $this->when($request->firstName == 'true',$this->firstName),
            'Email' => $this->when($request->email == 'true', $this->email),
        ];
    }
}
