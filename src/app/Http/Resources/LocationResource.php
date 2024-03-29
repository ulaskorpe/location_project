<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Http\Resources\UserResource;
class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id'=>(string)$this->id,
            'attributes'=>[
                'name'=>$this->name,
                'latitude'=>$this->latitude,
                'longitude'=>$this->longitude,
                'color'=>$this->color,
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
         
                ],
                'relationships'=>[
                    'id'=>(string)$this->user->id,
                    'user_name'=>(string)$this->user->name,
                    'user_email'=>(string)$this->user->email
                ]

        ]; //parent::toArray($request);
    }
}
