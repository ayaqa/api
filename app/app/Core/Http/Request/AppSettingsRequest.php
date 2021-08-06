<?php

namespace AyaQA\Core\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class AppSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'can_create_session' => 'boolean',
            'can_list_sessions' => 'boolean',
            'is_protected' => 'boolean',
            'session_limit' => 'integer',
            'new_password'  => 'string|between:3,10'
        ];
    }
}
