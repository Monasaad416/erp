<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => "string|max:100",
            'email' => "email|max:100",
            'password' => "confirmed",
        ];
    }
    public function messages()
    {
        return [
            'name.string' =>'الإسم يجب أن يكون أحرف',
            'name.max' => 'أقصي عدد احرف للإسم 100  حرف',

            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'email.unique' => 'البريد الإلكتروني الذي تم إدخالة بالفعل مسجل في قاعدة البيانات',

            'password.confirmed' => 'كلمة المرور وتأكيد كلمة المرور غير متطابقين',
        ];
    }
}
