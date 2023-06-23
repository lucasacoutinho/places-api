<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['filled', 'string', 'max:255'],
            'city' => ['filled', 'string', 'max:255'],
            'state' => ['filled', 'string', 'max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => __('The place name.'),
            ],
            'city' => [
                'description' => __('The city name.'),
            ],
            'state' => [
                'description' => __('The state name.'),
            ],
        ];
    }
}
