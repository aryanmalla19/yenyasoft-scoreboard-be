<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeagueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|unique:leagues,name',
            'logo' => 'nullable|sometimes|file|mimes:jpg,png,webp,jpeg',
            'description' => 'nullable|sometimes|string',
            'duration' => 'required|int|min:1',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ];
    }
}
