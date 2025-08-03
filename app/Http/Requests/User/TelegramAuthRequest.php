<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TelegramAuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'initData' => 'required|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        try {
            parse_str($this->initData, $parsedData);

            $this->merge([
                'parsed_data' => $parsedData,
                'user_data' => isset($parsedData['user'])
                    ? json_decode($parsedData['user'], true, 512, JSON_THROW_ON_ERROR)
                    : null,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to parse Telegram data', ['error' => $e]);
            throw ValidationException::withMessages([
                'initData' => 'Invalid Telegram data format'
            ]);
        }
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (empty($this->parsed_data['hash'])) {
                $validator->errors()->add('initData', 'Missing hash parameter');
            }

            if (empty($this->user_data)) {
                $validator->errors()->add('initData', 'Missing user data');
            } elseif (empty($this->user_data['id'])) {
                $validator->errors()->add('initData', 'Missing user ID');
            }
        });
    }
}
