<?php

namespace App\Http\Requests\User\Event;

use App\DTO\User\Event\TodayEventData;
use Illuminate\Foundation\Http\FormRequest;

class TodayEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'userId' => 'required|integer|exists:users,id'
        ];
    }

    public function messages(): array
    {
        return [
            'userId.required' => 'ID пользователя обязательно для заполнения',
            'userId.integer' => 'ID пользователя должен быть целым числом',
            'userId.exists' => 'Указанный пользователь не существует'
        ];
    }

    public function requestData(): TodayEventData
    {
        return new TodayEventData([
            'userId'    => $this->input('userId')
        ]);
    }
}


