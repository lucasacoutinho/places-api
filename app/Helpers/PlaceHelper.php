<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class PlaceHelper
{
    public function slug(string $name, string $city, string $state): string
    {
        return Str::slug(title: $name . '@' . $city . '@' . $state, language: 'pt_BR',);
    }
}
