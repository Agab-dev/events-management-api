<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price_in_pennies' => $this->price_in_pennies,
            'total_seats' => $this->total_seats,
            'group_discount' => $this->group_discount,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'owner' => new UserResource($this->whenLoaded('owner')),
            'attendees' => EventAttendeeResource::collection($this->whenLoaded('attendees'))
        ];
    }
}
