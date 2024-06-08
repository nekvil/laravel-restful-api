<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="NotebookResource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="full_name", type="string", example="Ivan Ivanov"),
 *     @OA\Property(property="company", type="string", example="Company ABC"),
 *     @OA\Property(property="phone", type="string", example="+79151234567"),
 *     @OA\Property(property="email", type="string", example="ivan.ivanov@test.com"),
 *     @OA\Property(property="birth_date", type="string", format="date", example="01.01.1999"),
 *     @OA\Property(property="photo", type="string", example="path/to/photo.jpg")
 * )
 */
class NotebookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'full_name' => $this->full_name,
            'company' => $this->company,
            'phone' => $this->phone,
            'email' => $this->email,
            'birth_date' => $this->birth_date,
            'photo' => $this->photo
        ];
    }
}