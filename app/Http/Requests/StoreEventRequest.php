<?php

namespace App\Http\Requests;

use App\Enums\MatchEventType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !($this->match->isEnded() || $this->match->isHalftime());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', new Enum(MatchEventType::class)],
            'team_id' => 'nullable|sometimes|exists:teams,id',
            'player_id' => 'nullable|sometimes|exists:players,id',
            'value' => 'nullable|sometimes|min:0',
        ];
    }

    protected function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException(
            'Match is already ended or in halftime.'
        );
    }
}
