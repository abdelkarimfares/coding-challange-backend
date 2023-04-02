<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @param $resource
     * @param $context
     */
    public function __construct($resource, protected $singleUser = false)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'username' => $this->username,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'age' => $this->age,
            'type' => $this->type,
            'email' => $this->email,
            'created_at' => $this->created_at,
        ];

        if ($this->singleUser) {
            $data['groups'] = GroupResource::collection($this->groups);
        }

        return $data;
    }
}
