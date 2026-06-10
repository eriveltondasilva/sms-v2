<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin SchoolYear */
class SchoolYearResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'year'   => $this->year,
            'status' => $this->status,
        ];
    }
}
