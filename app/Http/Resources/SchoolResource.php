<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin School */
class SchoolResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'slug'      => $this->slug,
            'fullName'  => $this->full_name,
            'shortName' => $this->short_name,
            'isActive'  => $this->is_active,
        ];
    }
}
