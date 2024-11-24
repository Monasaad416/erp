<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
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
              'name' => [
                'string',
                'max:255',
                Rule::unique('roles')->ignore($this->id, 'id')
            ],
            'permissions' => 'array',
        ];
    }

    public function messages()
    {
        return [

            'name.string' => 'إسم المهمة يجب أن يتكون من أحرف',
            'name.max' => 'أقصي عدد احرف لإسم المهمة 255 حرف',
            'name.unique' => 'إسم المهمة الذي تم إدخالة بالفعل مسجل في قاعد البيانات',
            'permissions.required' => 'الصلاحيات مطلوبة',
        ];

    }
}
