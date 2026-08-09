<?php

namespace App\Services\Tour;

use App\Models\TourPackage;
use Illuminate\Support\Str;

class TourPackageService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (
            TourPackage::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
